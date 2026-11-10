<?php

namespace App\Repositories\Eloquent;

use App\Enum\Filters\FilterV1Types;
use App\Repositories\Interface\BaseInterface;
use Illuminate\Container\Container as Application;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;

abstract class BaseEloquentRepository implements BaseInterface
{
    protected Model $model;

    protected array $filterable = [];

    protected array $sortable = [];

    protected array $allowedRelationships = [];

    protected function query(array $relations = []): Builder
    {
        return $this->model->newQuery()->with($relations);
    }

    protected function applyRelationships(
        Builder $query,
        array $relationships
    ): void {
        $invalidRelationships = array_diff(
            $relationships,
            $this->allowedRelationships
        );

        if ($invalidRelationships !== [])
        {
            throw ValidationException::withMessages([
                'relationships' => sprintf(
                    'Relacionamentos não permitidos: %s.',
                    implode(', ', $invalidRelationships)
                ),
            ]);
        }

        if ($relationships !== [])
        {
            $query->with($relationships);
        }
    }

    protected function applyFilters(
        Builder $query,
        array $filters
    ): void {
        foreach ($filters as $index => $filter) {
            $field = $filter['field'] ?? null;

            $filterType = strtoupper(
                $filter['filterType'] ?? ''
            );

            $hasValue = array_key_exists(
                'filterValue',
                $filter
            );

            $value = $filter['filterValue'] ?? null;

            if(
                !is_string($field)
                || !in_array($field, $this->filterable, true)
            ) throw ValidationException::withMessages([
                "filtersV2.{$index}.field" =>
                    "O campo {$field} não pode ser filtrado.",
            ]);

            if (
                !$hasValue
                && !in_array(
                    $filterType,
                    [FilterV1Types::IsNull->value, FilterV1Types::IsNotNull->value],
                    true
                )
            ) throw ValidationException::withMessages([
                "filtersV2.{$index}.filterValue" =>
                'O valor do filtro é obrigatório.',
            ]);


            $column = $this->model->qualifyColumn($field);

            match ($filterType) {
                FilterV1Types::Equal->value => $query->where(
                    $column,
                    '=',
                    $value
                ),

                FilterV1Types::NotEqual->value => $query->where(
                    $column,
                    '<>',
                    $value
                ),

                FilterV1Types::ILike->value => $query->whereLike(
                    $column,
                    '%' . $value . '%',
                    caseSensitive: false
                ),

                FilterV1Types::Like->value => $query->whereLike(
                    $column,
                    '%' . $value . '%',
                    caseSensitive: true
                ),

                FilterV1Types::GreaterThan->value => $query->where(
                    $column,
                    '>',
                    $value
                ),

                FilterV1Types::GreaterThanOrEqual->value => $query->where(
                    $column,
                    '>=',
                    $value
                ),

                FilterV1Types::LessThan->value => $query->where(
                    $column,
                    '<',
                    $value
                ),

                FilterV1Types::LessThanOrEqual->value => $query->where(
                    $column,
                    '<=',
                    $value
                ),

                FilterV1Types::In->value => $query->whereIn(
                    $column,
                    is_array($value) ? $value : [$value]
                ),

                FilterV1Types::NotIn->value => $query->whereNotIn(
                    $column,
                    is_array($value) ? $value : [$value]
                ),

                FilterV1Types::IsNull->value => $query->whereNull($column),

                FilterV1Types::IsNotNull->value => $query->whereNotNull($column),

                default => throw ValidationException::withMessages([
                    "filtersV2.{$index}.filterType" =>
                        "O tipo de filtro {$filterType} não é permitido.",
                ]),
            };
        }
    }

    protected function applyOrderBy(
        Builder $query,
        array $orderBy
    ): void {
        if ($orderBy === [])
        {
            $query->orderByDesc(
                $this->model->getQualifiedKeyName()
            );

            return;
        }

        foreach ($orderBy as $field => $direction) {
            $direction = strtolower($direction);

            if(
                !in_array($field, $this->sortable, true)
            ) throw ValidationException::withMessages([
                "orderBy.{$field}" =>
                "O campo {$field} não pode ser ordenado.",
            ]);

            if (
                !in_array($direction, ['asc', 'desc', true])
            ) throw ValidationException::withMessages([
                "orderBy.{$field}" =>
                'A direção deve ser asc ou desc.',
            ]);

            $query->orderBy(
                $this->model->qualifyColumn($field),
                $direction
            );
        }
    }

    public function __construct(protected Application $app)
    {
        $this->model = $this->makeModel();
        $this->app = $app;
    }

    abstract protected function modelClass(): string;
    public function makeModel(): Model
    {
        $_model = $this->app->make($this->modelClass());

        if (!$_model instanceof Model)  throw new \InvalidArgumentException("A classe {$this->modelClass()} deve ser um Model do Eloquent.");

        return $this->model = $_model;
    }

    public function newQuery(): Builder
    {
        return $this->model->newQuery();
    }

    public function all(
        array $parameters = [],
        array $columns = ['*'],
    ): Paginator
    {
        $query = $this->model->newQuery();

        $this->applyRelationships(
            $query,
            $parameters['relationships'] ?? []
        );

        $this->applyFilters(
            $query,
            $parameters['filtersV1'] ?? []
        );

        $this->applyOrderBy(
            $query,
            $parameters['orderBy'] ?? []
        );

        $perPage = max(
            1,
            min(
                (int) ($parameters['paginate'] ?? 15),
                100
            )
        );

        return $query->paginate(
            perPage: $perPage,
            columns: $columns
        );
    }

    public function create(array $data): Model
    {
        $model = $this->model->newInstance($data);

        $model->save();

        return $model;
    }

    public function find(int $id, array $columns = ['*']): ?Model
    {
        $query = $this->model->newQuery();

        return $query->find($id, $columns);
    }

    public function update(Model $model, array $data): Model
    {
        $model->fill($data);

        $model->save();

        return $model;
    }

    public function findBy(array $parameters = [], array $columns = ['*'], array $relationships = []): ?Model
    {
        if ($parameters === []) {
            throw new InvalidArgumentException(
                'É necessário informar pelo menos um parâmetro para a busca.'
            );
        }

        $query = $this->model
            ->newQuery()
            ->with($relationships)
            ->select($columns);

        foreach ($parameters as $column => $value)
        {
            $query->where($column, $value);
        }

        Log::info('q', ['q' => $query]);

        return $query->first();
    }

    public function existsBy(array $parameters): bool
    {
        if ($parameters === []) {
            return false;
        }

        $query = $this->model->newQuery();

        foreach ($parameters as $column => $value)
        {
            if ($value === null)
            {
                $query->whereNull($column);

                continue;
            }

            $query->where($column, $value);
        }

        return $query->exists();
    }
}
