<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interface\BaseInterface;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseEloquentRepository implements BaseInterface
{
    protected Model $model;

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

    public function all(array $columns = ['*']): Collection
    {
        return $this->model->all($columns);
    }

    public function create(array $data): Model
    {
        $model = $this->model->newInstance($data);

        $model->save();

        return $model;
    }

    public function find(int $id, $columns = ['*']): ?Model
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
}
