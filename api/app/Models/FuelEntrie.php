<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(
    'vehicle_id',
    'refueled_at',
    'liters',
    'price_per_liter',
    'total_amount',
    'odometer_km',
    'full_tank',
    'location_name'
)]
class FuelEntrie extends Model
{
    protected $casts = [
        'liters' => 'decimal:2',
        'price_per_liter' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'odometer_km' => 'decimal:2',
    ];
}
