<?php

namespace Someline\Listeners\User;

use Someline\Events\OAuthTokenPasswordLogin;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Someline\Jobs\PostDateToGameServer;

class OAuthTokenPasswordLoginListener
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
     * @param  OAuthTokenPasswordLogin $event
     * @return void
     */
    public function handle(OAuthTokenPasswordLogin $event)
    {
        $tokenInfo = $event->tokenInfo;
        $tokenInfo['event'] = 'login';
        $tokenInfo['timestamp'] = time();
        $tokenInfo['sign'] = md5($tokenInfo['event'] . $tokenInfo['timestamp'] . $tokenInfo['user_id']);


        /**
         * 队列发送通知到服务端
         */
        $notifyUrls = config('game-server.payNotifyServerList');


        dispatch(new PostDateToGameServer($tokenInfo, $notifyUrls));


    }
}
