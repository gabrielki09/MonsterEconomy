<?php

namespace App\Models\Monster;

use App\Models\Purchase;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(
    'name',
    'volume_ml'
)]
class MonsterProduct extends Model
{
    use SoftDeletes;

    protected $casts = [
        'volume_ml' => 'decimal:2'
    ];

    public function monsterProductWithMonsterPrices(): HasMany
    {
        return $this->hasMany(MonsterPrice::class, 'monster_product_id', 'id');
    }

    public function monsterProductWithPurchases(): HasMany
    {
        return $this->hasMany(Purchase::class, 'monster_product_id', 'id');
    }
}
