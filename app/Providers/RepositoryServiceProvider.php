<?php

namespace App\Providers;

use App\Contracts\PositionsRepositoryInterface;
use App\Contracts\UsersRepositoryInterface;
use App\Repositories\PositionsRepository;
use App\Repositories\UsersRepository;
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
        $this->app->bind(UsersRepositoryInterface::class, UsersRepository::class);
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
