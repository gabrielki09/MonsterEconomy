<?php

namespace App\Services\MonsterService;

use App\Models\Monster\MonsterProduct;
use App\Repositories\Interface\MonsterInterface\MonsterPriceInterface;
use App\Repositories\Interface\MonsterInterface\MonsterProductInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class MonsterProductService
{
    public function __construct(
        protected MonsterProductInterface $monsterProductRepository,
        protected MonsterPriceInterface $monsterPriceRepository
    ) {}

    public function all(
        array $parameters
    ): Paginator {
        return $this->monsterProductRepository->all(
            parameters: $parameters
        );
    }

    public function findBy(
        array $parameters = [],
        array $columns = ['*'],
        array $relationships = []
    ): ?MonsterProduct {
        return $this->monsterProductRepository->findBy(
            parameters: $parameters,
            columns: $columns,
            relationships: $relationships
        );
    }

    public function create(array $data)
    {
        return DB::transaction(function() use ($data) {
            $monster = $this->monsterProductRepository->create([
                'name' => $data['name'],
                'volume_ml' => $data['volume_ml'],
            ]);

            if (isset($data['prices']))
            {
                foreach ($data['prices'] ?? [] as $priceData) {
                    $this->monsterPriceRepository->create([
                        'monster_product_id' => $monster->id,
                        'location_id' => $priceData['location_id'] ?? null,
                        'unit_price' => $priceData['unit_price'],
                    ]);
                }
            };

            return $monster->with('monsterProductWithMonsterPrices')->get();
        });
    }

    public function update(array $data, int $id): MonsterProduct
    {
        return DB::transaction(function() use ($data, $id) {
            $monster = $this->monsterProductRepository->update($this->find($id), $data);

            if (isset($data['price'])) $this->monsterPriceRepository->update($this->monsterPriceRepository->find(id: $id), $data['price']);

            return $monster->with('monsterProductWithMonsterPrices')->get();
        });
    }

    public function find(int $id, array $columns = ['*'],): ?MonsterProduct
    {
        $monster = $this->monsterProductRepository->find(
            id: $id,
            columns: $columns
        );

        if ($monster === null) throw (new ModelNotFoundException())->setModel(MonsterProduct::class, [$id]);

        return $monster;
    }
}
