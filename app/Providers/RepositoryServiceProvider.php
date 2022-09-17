<?php

namespace App\Providers;

use App\Interfaces\PositionsRepositoryInterface;
use App\Repositories\PositionsRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PositionsRepositoryInterface::class, PositionsRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
