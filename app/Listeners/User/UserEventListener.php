<?php
/**
 * Created for someline-starter.
 * User: Libern
 */

namespace Someline\Listeners\User;


use Someline\Events\User\UserLoggedInEvent;
use Someline\Events\User\UserRegisteredEvent;
use Someline\Models\BaseModel;
use Illuminate\Auth\Events\Login;

class UserEventListener
{

    public function __construct()
    {
    }


    /**
     * Handle user login events.
     * @param UserLoggedInEvent $event
     */
    public function onUserLogin(Login $event)
    {
        \Log::info('login-------------');
        
    }

    /**
     * Handle user registered events.
     * @param UserRegisteredEvent $event
     */
    public function onUserRegistered(UserRegisteredEvent $event)
    {
        \Log::info(' user api register  event------');
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout($event)
    {
        \Log::info(' user logout event------');
     
    }

    public function test()
    {
        \Log::info('test-------------');

    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'Someline\Listeners\User\UserEventListener@onUserLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'Someline\Listeners\User\UserEventListener@onUserLogout'
        );
        $events->listen(
            'auth.attempt',
            'Someline\Listeners\User\UserEventListener@onUserRegistered'
        );

//
//        $events->listen(
//            UserRegisteredEvent::class,
//            'Someline\Listeners\User\UserEventListener@onUserRegistered'
//        );

//        $events->listen(
//            'Illuminate\Auth\Events\Login',
//            'Someline\Listeners\User\UserEventListener@onUserLogin'
//        );
    }

}