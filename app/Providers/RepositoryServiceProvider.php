<?php

namespace Someline\Providers;

use Illuminate\Support\ServiceProvider;
use Someline\Repositories\Eloquent\UserRepositoryEloquent;
use Someline\Repositories\Interfaces\UserRepository;
use Someline\Repositories\Interfaces\OrderRepository;
use Someline\Repositories\Eloquent\OrderRepositoryEloquent ;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepository::class, UserRepositoryEloquent::class);
        $this->app->bind(OrderRepository::class, OrderRepositoryEloquent::class);
        $this->app->bind(\Someline\Repositories\Interfaces\PostRepository::class, \Someline\Repositories\Eloquent\PostRepositoryEloquent::class);
        //:end-bindings:
    }
}
