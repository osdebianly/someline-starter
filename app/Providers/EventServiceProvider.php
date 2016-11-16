<?php

namespace Someline\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Someline\Listeners\User\UserEventListener;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        /**
         * 自定义Password 登录事件, 登录后触发
         * Path: vendor/laravel/passport/src/Http/Controllers/AccessTokenController.php::76
         */
        'Someline\Events\OAuthTokenPasswordLogin' => [
            'Someline\Listeners\User\OAuthTokenPasswordLoginListener',
        ],
        'Someline\Events\OrderNotPay' => [
            'Someline\Listeners\OrderNotPayListener'
        ],
        'Someline\Events\OrderPaid' => [
            'Someline\Listeners\OrderPaidListener'
        ],
    ];

    protected $subscribe = [
        UserEventListener::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
