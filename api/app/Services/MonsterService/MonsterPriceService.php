<?php

namespace App\Services\MonsterService;

use App\Models\Monster\MonsterPrice;
use App\Repositories\Interface\MonsterInterface\MonsterPriceInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MonsterPriceService
{
    public function __construct(
        protected MonsterPriceInterface $monsterPriceRepository
    ) {}

    public function all(
        array $parameters
    ): Paginator {
        return $this->monsterPriceRepository->all(
            parameters: $parameters
        );
    }

    public function findBy(
        array $parameters = [],
        array $columns = ['*'],
        array $relationships = []
    ): ?MonsterPrice {
        return $this->monsterPriceRepository->findBy(
            parameters: $parameters,
            columns: $columns,
            relationships: $relationships
        );
    }

    public function create(array $data)
    {
        return $this->monsterPriceRepository->create($data);
    }

    public function update(array $data, int $id): MonsterPrice
    {
        $monsterPrice = $this->monsterPriceRepository->update($this->find($id), $data);

        return $monsterPrice;
    }

    public function find(int $id, array $columns = ['*'],): ?MonsterPrice
    {
        $monsterPrice = $this->monsterPriceRepository->find(
            id: $id,
            columns: $columns
        );

        if ($monsterPrice === null) throw (new ModelNotFoundException())->setModel(MonsterPrice::class, [$id]);

        return $monsterPrice;
    }
}
