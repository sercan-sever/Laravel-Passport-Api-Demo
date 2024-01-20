<?php

namespace App\Providers;

use App\Services\Interfaces\AuthenticationInterface;
use App\Services\Interfaces\ProductContentInterface;
use App\Services\Interfaces\ProductInterface;
use App\Services\Repositories\AuthenticationRepository;
use App\Services\Repositories\ProductContentRepository;
use App\Services\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Auth
        app()->bind(AuthenticationInterface::class, AuthenticationRepository::class);

        // Product
        app()->bind(ProductInterface::class, ProductRepository::class);
        app()->bind(ProductContentInterface::class, ProductContentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
