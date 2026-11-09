<?php

namespace App\Models\Location;

use App\Casts\Time\TimeCast;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(
    'location_id',
    'vehicle_id',
    'one_way_distance_km',
    'round_trip_distance_km',
    'estimated_minutes'
)]
class LocationRoute extends Model
{
    use SoftDeletes;

    protected $casts = [
        'one_way_distance_km' => 'decimal:2',
        'round_trip_distance_km' => 'decimal:2',
        'estimated_minutes' => TimeCast::class,
    ];
}
