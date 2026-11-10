<?php

namespace App\Repositories\Eloquent\MonsterEloquent;

use App\Models\Monster\MonsterPrice;
use App\Repositories\Eloquent\BaseEloquentRepository;
use App\Repositories\Interface\MonsterInterface\MonsterPriceInterface;

class MonsterPriceEloquentRepository extends BaseEloquentRepository implements MonsterPriceInterface
{
    protected array $allowedRelationships = [
        'monsterProductWithMonsterPrices',
        'monsterProductWithPurchases',
    ];

    protected array $filterable = [
        'id',
        'location_id',
        'monster_product_id',
        'unit_price',
        'available',
        'created_at',
        'updated_at'
    ];

    protected array $sortable = [
        'unit_price',
        'created_at',
        'updated_at'
    ];

    protected function modelClass(): string
    {
        return MonsterPrice::class;
    }
}
