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
        /**
        * $tokenInfo = $event->tokenInfo;
        * $tokenInfo['event'] = 'login';
        * $tokenInfo['timestamp'] = time();
        * $tokenInfo['sign'] = md5($tokenInfo['event'] . $tokenInfo['timestamp'] . $tokenInfo['user_id']);
         */

        /**
         * 使用旧的数据结构
         */
        //$tokenInfo = $event->tokenInfo;
        $postInfo = $event->tokenInfo['post_info'];
        $userInfo = $event->tokenInfo['user_info'];
        $tokenInfo = $event->tokenInfo['token_info'];

        $data['appid'] = isset($postInfo['client_id']) ? (int)$postInfo['client_id'] : 1;
        $data['event'] = json_encode([
            "TYPE" => "EVENT_ACCOUNT_SESSION",
            "DATA" => [
                "UserID" => (string)$userInfo['user_id'],
                "UserStatus" => isset($userInfo['status']) ? (string)$userInfo['status'] : '0',
                "SessionID" => $tokenInfo['session']
            ]
        ]);
        $data['serverid'] = isset($postInfo['server_id']) ? (int)$postInfo['server_id'] : 1;
        $data['ts'] = time();
        $data['sign'] = md5($data['appid'] . $data['ts']) ;
        
        /**
         * 队列发送通知到服务端
         */
        $notifyUrls = config('game-server.payNotifyServerList');

        dispatch(new PostDateToGameServer($data, $notifyUrls));
        
    }
}
