<?php

namespace App\Repositories\Eloquent\LocationEloquent ;

use App\Models\Location\LocationOperatingDay;
use App\Repositories\Eloquent\BaseEloquentRepository;
use App\Repositories\Interface\LocationInterface\LocationOperatingDayInterface;

class LocationOperatingDayEloquentRepository extends BaseEloquentRepository implements LocationOperatingDayInterface
{
    protected function modelClass(): string
    {
        return LocationOperatingDay::class;
    }
}
