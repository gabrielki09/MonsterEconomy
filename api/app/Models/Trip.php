<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(
    'location_id',
    'vehicle_id',
    'departed_at',
    'arrived_at',
    'returned_at',
    'outbound_distance_km',
    'total_distance_km',
    'average_speed_kmh',
    'estimated_fuel_liters',
    'estimated_fuel_cost',
    'actual_fuel_cost',
    'notes'
)]
class Trip extends Model
{
    protected $casts = [
        'outbound_distance_km' => 'decimal:2',
        'total_distance_km' => 'decimal:2',
        'average_speed_kmh' => 'decimal:2',
        'estimated_fuel_liters' => 'decimal:2',
        'estimated_fuel_cost' => 'decimal:2',
        'actual_fuel_cost' => 'decimal:2',
    ];

    public function tripWithPurchases(): HasMany
    {
        return $this->hasMany(Purchase::class, 'trip_id', 'id');
    }
}
