<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Supplier\SupplierRepositoriesInterface;
use App\Repositories\Supplier\SupplierRepositories;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(SupplierRepositoriesInterface::class, SupplierRepositories::class);
    }

    public function boot()
    {
        //
    }
}
