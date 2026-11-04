<?php

namespace App\Repositories\Eloquent\LocationEloquent ;

use App\Models\Location\LocationRoute;
use App\Repositories\Eloquent\BaseEloquentRepository;
use App\Repositories\Interface\LocationInterface\LocationRouteInterface;

class LocationRouteEloquentRepository extends BaseEloquentRepository implements LocationRouteInterface
{
    protected function modelClass(): string
    {
        return LocationRoute::class;
    }
}
