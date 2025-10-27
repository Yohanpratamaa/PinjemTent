<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\UnitRepository;
use App\Repositories\KategoriRepository;
use App\Repositories\UserRepository;
use App\Repositories\PeminjamanRepository;
use App\Services\Admin\UnitService;
use App\Services\Admin\KategoriService;
use App\Services\Admin\UserService;
use App\Services\Admin\PeminjamanService;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register Repositories
        $this->app->bind(UnitRepository::class, UnitRepository::class);
        $this->app->bind(KategoriRepository::class, KategoriRepository::class);
        $this->app->bind(UserRepository::class, UserRepository::class);
        $this->app->bind(PeminjamanRepository::class, PeminjamanRepository::class);

        // Register Services with proper dependencies
        $this->app->bind(UnitService::class, function ($app) {
            return new UnitService(
                $app->make(UnitRepository::class),
                $app->make(KategoriRepository::class)
            );
        });

        $this->app->bind(KategoriService::class, function ($app) {
            return new KategoriService(
                $app->make(KategoriRepository::class)
            );
        });

        $this->app->bind(UserService::class, function ($app) {
            return new UserService(
                $app->make(UserRepository::class)
            );
        });

        $this->app->bind(PeminjamanService::class, function ($app) {
            return new PeminjamanService(
                $app->make(PeminjamanRepository::class),
                $app->make(UnitRepository::class),
                $app->make(UserRepository::class)
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
