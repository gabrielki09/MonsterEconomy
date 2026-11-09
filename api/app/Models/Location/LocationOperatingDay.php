<?php

namespace App\Models\Location;

use App\Casts\DayCast;
use App\Casts\Time\TimeCast;
use App\Enum\Days\WeekDay;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(
    'location_id',
    'opening_day',
    'opens_at',
    'closes_at'
)]
class LocationOperatingDay extends Model
{
    use SoftDeletes;

    protected function casts()
    {
        return [
            'opening_day' => WeekDay::class,
            'closes_at' => TimeCast::class,
            'opens_at' => TimeCast::class
        ];
    }
}
