<?php

namespace Someline\Listeners;

use Someline\Events\OrderNotPay;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Notifynder;

class OrderNotPayListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderNotPay $event
     * @return void
     */
    public function handle(OrderNotPay $event)
    {
        $user = $event->user;
        $userID = $user->getUserId();

        Notifynder::category('user.notpay')
            ->from($userID)
            ->to($userID)
            ->url('http://localhost')
            ->send();

    }
}
