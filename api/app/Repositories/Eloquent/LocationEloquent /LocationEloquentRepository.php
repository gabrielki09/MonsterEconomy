<?php

namespace App\Repositories\Eloquent\LocationEloquent ;

use App\Models\Location\Location;
use App\Repositories\Eloquent\BaseEloquentRepository;
use App\Repositories\Interface\LocationInterface\LocationInterface;

class LocationEloquentRepository extends BaseEloquentRepository implements LocationInterface
{
    protected function modelClass(): string
    {
        return Location::class;
    }
}
