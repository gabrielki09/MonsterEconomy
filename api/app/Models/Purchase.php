<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(
    'location_id',
    'trip_id',
    'monster_product_id',
    'purchased_at',
    'quantity',
    'unit_price',
    'total_price'
)]
class Purchase extends Model
{
    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];
}
