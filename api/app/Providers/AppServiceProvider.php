<?php

namespace App\Providers;

use App\Repositories\Eloquent\BaseEloquentRepository;
use App\Repositories\Eloquent\LocationEloquent\LocationEloquentRepository;
use App\Repositories\Eloquent\LocationEloquent\LocationOperatingDayEloquentRepository;
use App\Repositories\Eloquent\LocationEloquent\LocationRouteEloquentRepository;
use App\Repositories\Eloquent\MonsterEloquent\MonsterPriceEloquentRepository;
use App\Repositories\Eloquent\MonsterEloquent\MonsterProductEloquentRepository;
use App\Repositories\Eloquent\VehicleEloquent\VehicleEloquentRepository;
use App\Repositories\Interface\BaseInterface;
use App\Repositories\Interface\LocationInterface\LocationInterface;
use App\Repositories\Interface\LocationInterface\LocationOperatingDayInterface;
use App\Repositories\Interface\LocationInterface\LocationRouteInterface;
use App\Repositories\Interface\MonsterInterface\MonsterPriceInterface;
use App\Repositories\Interface\MonsterInterface\MonsterProductInterface;
use App\Repositories\Interface\VehicleInterface\VehicleInterface;
use App\Services\CEPService\CEPService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app
            ->when(CEPService::class)
            ->needs('$apiURL')
            ->giveConfig('services.cep.url');

        $this->app->bind(
            BaseInterface::class,
            BaseEloquentRepository::class
        );

        $this->app->bind(
            VehicleInterface::class,
            VehicleEloquentRepository::class
        );

        $this->app->bind(
            LocationInterface::class,
            LocationEloquentRepository::class
        );

        $this->app->bind(
            LocationRouteInterface::class,
            LocationRouteEloquentRepository::class
        );

        $this->app->bind(
            LocationOperatingDayInterface::class,
            LocationOperatingDayEloquentRepository::class
        );

        $this->app->bind(
            MonsterProductInterface::class,
            MonsterProductEloquentRepository::class
        );

        $this->app->bind(
            MonsterPriceInterface::class,
            MonsterPriceEloquentRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
