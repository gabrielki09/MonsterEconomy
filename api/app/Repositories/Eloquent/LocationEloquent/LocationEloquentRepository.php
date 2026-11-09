<?php

namespace App\Repositories\Eloquent\LocationEloquent ;

use App\Models\Location\Location;
use App\Repositories\Eloquent\BaseEloquentRepository;
use App\Repositories\Interface\LocationInterface\LocationInterface;

class LocationEloquentRepository extends BaseEloquentRepository implements LocationInterface
{
    protected array $allowedRelationships = [
        'locationWithMonsterPrices',
        'locationWithLocationRoutes',
        'locationWithTrips',
        'locationWithLocationOperatingDay'
    ];

    protected array $filterable = [
        'id',
        'name',
        'road',
        'address',
        'cep',
        'latitude',
        'longitude',
        'notes',
        'shares_more_than_one_location',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected array $sortable = [
        'name',
        'road',
        'address',
        'cep',
        'latitude',
        'longitude',
        'notes',
    ];

    protected function modelClass(): string
    {
        return Location::class;
    }

}
