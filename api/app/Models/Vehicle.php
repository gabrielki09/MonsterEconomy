<?php

namespace App\Models;

use App\Enum\Vehicle\VehicleTypes;
use App\Models\Location\LocationRoute;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(
    'model',
    'actual_avg',
    'year',
    'type',
)]
class Vehicle extends Model
{
    protected function casts()
    {
        return [
            'actual_avg' => 'decimal:2',
            'type' => VehicleTypes::class,
        ];
    }

    public function vehicleWithLocationRoutes(): HasMany
    {
        return $this->hasMany(LocationRoute::class, 'vehicle_id', 'id');
    }

    public function vehicleWithTrips(): HasMany
    {
        return $this->hasMany(Trip::class, 'vehicle_id', 'id');
    }

    public function vehicleWithFuelEntries(): HasMany
    {
        return $this->hasMany(FuelEntrie::class, 'vehicle_id', 'id');
    }
}
