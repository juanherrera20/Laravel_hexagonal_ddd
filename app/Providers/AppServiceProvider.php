<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Src\CustomerManagement\Customer\Domain\Contracts\CustomerRepositoryInterface;
use Src\CustomerManagement\Customer\Infrastructure\Repositories\EloquentCustomerRepository;
use Src\IdentityAndAccess\User\Domain\Contracts\UserRepositoryInterface;
use Src\IdentityAndAccess\User\Infrastructure\Repositories\EloquentUserRepository;
use Src\ProductManagement\Product\Domain\Contract\ProductRepositoryInterface;
use Src\ProductManagement\Product\Infrastructure\Repositories\EloquentProductRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, EloquentProductRepository::class);
        $this->app->bind(CustomerRepositoryInterface::class, EloquentCustomerRepository::class);
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
