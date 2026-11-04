<?php

namespace App\Repositories\Eloquent\VehicleEloquent;

use App\Models\Vehicle;
use App\Repositories\Eloquent\BaseEloquentRepository;
use App\Repositories\Interface\VehicleInterface\VehicleInterface;

class VehicleEloquentRepository extends BaseEloquentRepository implements VehicleInterface
{
    protected function modelClass(): string
    {
        return Vehicle::class;
    }
}
