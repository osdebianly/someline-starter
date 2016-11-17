<?php

return [

    /*
    |--------------------------------------------------------------------------
    | 游戏服务器配置文件
    |--------------------------------------------------------------------------
    |
    |
    */

    'payNotifyServerList' => env('PAY_NOTIFY_SERVER_LIST', ['http://192.168.2.67']),

    /*
    |--------------------------------------------------------------------------
    | 开发者模式
    |--------------------------------------------------------------------------
    |
    |
    */

    'debug' => env('API_DEBUG', false),


    /*
    |--------------------------------------------------------------------------
    | 后端服务器的ClientID, 这里设置白名单 由 backendServerMiddleware 过滤
    | secret 见 oauth_clients
    |--------------------------------------------------------------------------
    |
    |
    */

    'backendServerClients' => [
        'server'
    ],

    /*
   |--------------------------------------------------------------------------
   | 单个ＵＵＩＤ,最多可注册账号,(包含一个游客账号)
   |--------------------------------------------------------------------------
   |
   |
   */

    'maxUserNumber' => 30,

];
