<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Src\CustomerManagement\Customer\Domain\Contracts\CustomerRepositoryInterface;
use Src\CustomerManagement\Customer\Infrastructure\Repositories\EloquentCustomerRepository;
use Src\IdentityAndAccess\User\Domain\Contracts\UserRepositoryInterface;
use Src\IdentityAndAccess\User\Infrastructure\Repositories\EloquentUserRepository;
use Src\OrderManagement\Order\Infrastructure\Adapters\ProductLookupAdapter;
use Src\OrderManagement\Order\Domain\Contracts\OrderRepositoryInterface;
use Src\OrderManagement\Order\Domain\Contracts\ProductLookupServiceInterface;
use Src\OrderManagement\Order\Infrastructure\Repositories\EloquentOrderRepository;
use Src\ProductManagement\Product\Domain\Contract\ProductRepositoryInterface;
use Src\ProductManagement\Product\Domain\Contract\QrGeneratorInterface;
use Src\ProductManagement\Product\Infrastructure\Repositories\EloquentProductRepository;
use Src\ProductManagement\Product\Infrastructure\Services\GoQrGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //Products
        $this->app->bind(ProductRepositoryInterface::class, EloquentProductRepository::class);
        $this->app->bind(QrGeneratorInterface::class, GoQrGenerator::class);

        //Customers
        $this->app->bind(CustomerRepositoryInterface::class, EloquentCustomerRepository::class);

        //user
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);

        //oders
        $this->app->bind(OrderRepositoryInterface::class,EloquentOrderRepository::class);
        $this->app->bind(ProductLookupServiceInterface::class,ProductLookupAdapter::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
