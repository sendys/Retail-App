<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\COA\COARepositoriesInterface;
use App\Repositories\COA\COARepositories;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Product\ProductRepository;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //Tambahkan fungsi berikut
        $this->app->bind(COARepositoriesInterface::class, COARepositories::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
