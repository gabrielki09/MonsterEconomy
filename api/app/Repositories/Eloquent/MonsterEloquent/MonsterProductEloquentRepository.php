<?php

namespace App\Repositories\Eloquent\MonsterEloquent;

use App\Models\Monster\MonsterProduct;
use App\Repositories\Eloquent\BaseEloquentRepository;
use App\Repositories\Interface\MonsterInterface\MonsterProductInterface;

class MonsterProductEloquentRepository extends BaseEloquentRepository implements MonsterProductInterface
{
    protected array $allowedRelationships = [
        'monsterProductWithMonsterPrices',
        'monsterProductWithPurchases',
    ];

    protected array $filterable = [
        'id',
        'name',
        'volume_ml',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected array $sortable = [
        'name',
        'volume_ml',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function modelClass(): string
    {
        return MonsterProduct::class;
    }
}
