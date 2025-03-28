<?php

namespace App\Providers;

use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\PlantRepositoryInterface;
use App\Repositories\Interfaces\StatisticsRepositoryInterface;
use App\Repositories\OrderRepository;
use App\Repositories\PlantRepository;
use App\Repositories\StatisticsRepository;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
        $this->app->bind(
            PlantRepositoryInterface::class,
            PlantRepository::class
        );
        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );
        $this->app->bind(
            StatisticsRepositoryInterface::class,
            StatisticsRepository::class,
        );
    }
}
