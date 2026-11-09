<?php

namespace App\Models\Location;

use App\Models\Monster\MonsterPrice;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(
    'name',
    'cep',
    'road',
    'address',
    'latitude',
    'longitude',
    'notes',
    'shares_more_than_one_location',
)]
class Location extends Model
{
    use SoftDeletes;

    protected $casts = [
        'shares_more_than_one_location' => 'boolean'
    ];

    public function locationWithMonsterPrices(): HasMany
    {
        return $this->hasMany(MonsterPrice::class, 'location_id', 'id');
    }

    public function locationWithLocationRoutes(): HasMany
    {
        return $this->hasMany(LocationRoute::class, 'location_id', 'id');
    }

    public function locationWithTrips(): HasMany
    {
        return $this->hasMany(Trip::class, 'location_id', 'id');
    }

    public function locationWithLocationOperatingDay() : HasMany {

        return $this->hasMany(LocationOperatingDay::class, 'location_id', 'id');
    }
}
