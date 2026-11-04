<?php

namespace App\Models\Monster;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(
    'location_id',
    'monster_product_id',
    'unit_price',
    'recorded_at',
    'available'
)]
class MonsterPrice extends Model
{
    protected $casts = [
        'unit_price' => 'decimal:2',
        'recorded_at' => 'decimal:2',
    ];
}
