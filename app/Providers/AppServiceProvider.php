<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Supplier\SupplierRepositoriesInterface;
use App\Repositories\Supplier\SupplierRepositories;
use App\Repositories\COA\COARepositoriesInterface;
use App\Repositories\COA\COARepositories;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(SupplierRepositoriesInterface::class, SupplierRepositories::class);
        $this->app->bind(COARepositoriesInterface::class, COARepositories::class);
    }

    public function boot()
    {
        //
    }
}
