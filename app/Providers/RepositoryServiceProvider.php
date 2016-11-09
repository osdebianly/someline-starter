<?php

namespace Someline\Providers;

use Illuminate\Support\ServiceProvider;
use Someline\Repositories\Eloquent\UserRepositoryEloquent;
use Someline\Repositories\Interfaces\UserRepository;
use Someline\Repositories\Interfaces\OrderRepository;
use Someline\Repositories\Eloquent\OrderRepositoryEloquent ;
use Someline\Repositories\Interfaces\PayRepository;
use Someline\Repositories\Eloquent\PayRepositoryEloquent;
use Someline\Repositories\Interfaces\PublicationRepository;
use Someline\Repositories\Eloquent\PublicationRepositoryEloquent;

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
        $this->app->bind(PayRepository::class, PayRepositoryEloquent::class);
        $this->app->bind(PublicationRepository::class, PublicationRepositoryEloquent::class);

        //:end-bindings:
    }
}
