<?php

namespace App\Models\Location;

use App\Casts\Time\TimeCast;
use App\Models\Monster\MonsterPrice;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(
    'name',
    'cep',
    'address',
    'latitude',
    'longitude',
    'opening_time',
    'closing_time',
    'notes'
)]
class Location extends Model
{
    protected function casts()
    {
        return [
            'opening_time' => TimeCast::class,
            'closing_time' => TimeCast::class
        ];
    }

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
}
