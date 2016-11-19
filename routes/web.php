<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Auth Routes
Auth::routes();

// Locale Routes
Route::group(['prefix' => 'locales'], function () {

    Route::get('/{locale}.js', '\Someline\Support\Controllers\LocaleController@getLocaleJs');

    Route::get('/switch/{locale}', '\Someline\Support\Controllers\LocaleController@getSwitchLocale');

});

// Basic Routes
Route::get('/home', 'HomeController@index');

// Image Routes
Route::get('/image/{name}', 'ImageController@showOriginalImage');
Route::post('/image', 'ImageController@postImage');

// Protected Routes
Route::group(['middleware' => 'auth'], function () {

    Route::get('/', function () {
        return redirect('users');
    });

    Route::get('users', 'UserController@getUserList');

});

// Console Routes
Route::group(['prefix' => 'console'], function () {

    Route::get('oauth', function () {
        return view('console.oauth');
    });

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

});
// 配置信息
Route::group(['prefix' => 'config'], function () {
    Route::get('/qiniu', function () {
        $disk = \Storage::disk('qiniu');
        $data['base_url'] = config('filesystems.disks.qiniu.domains.custom') ?: config('filesystems.disks.qiniu.domains.default');
        $data['upload_token'] = $disk->uploadToken();
        return $data;
    });
});

/**
 * 管理员
 */
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'Admin\HomeController@index');
});

Route::get('/test/hashids/{id}', function ($id) {
    return Hashids::encode($id);
});
Route::get('/test/decodehashids/{id}', function ($id) {
    return Hashids::decode($id);
});

Route::any('/test/send-order', function () {
    $notify_url = request('notify_url');
    dd($notify_url);
    $isFirstPay = \Someline\Models\Order::where('user_id', 3)->count();

    $order = \Someline\Models\Order::find(30);
    $user = \Someline\Models\Foundation\User::find($order->user_id);

    $postData['appid'] = (int)$order->client_id;
    $postData['event'] = [
        "TYPE" => "EVENT_PAY_ORDER_CONFIRM",
        "Data" => [
            "OrderID" => (string)$order->id,
            "OrderType" => "package",
            "PayChannel" => "1",
            "PayID" => "44",

            "UserID" => (string)$order->user_id,
            "AppID" => (string)$order->client_id,
            "ServerID" => "1",
            "CurrencyType" => "CNY",
            "CurrencyAmount" => (string)$order->price,

            "Gift" => "0",
            "GameGift" => "0",
            "SubmitTime" => (string)$order->created_at,

            "Source" => "a_01",
            "OS" => "IOS",
            "Version" => "51.2.1",
            "FinishTime" => "2016-10-27 13:30:58",
            "isFirstPay" => $isFirstPay > 0 ? false : true,
            "isAppFirstPay" => $isFirstPay > 0 ? false : true,
            "Sandbox" => "0",
            "PayAmount" => (string)$order->price,

            "AccountStatus" => (string)$user->status,
        ]
    ];
    $postData['serverid'] = isset($postInfo['server_id']) ? (int)$postInfo['server_id'] : 1;
    $postData['ts'] = time();
    $postData['sign'] = md5($postData['appid'] . $postData['ts']);

    /**
     * 队列发送通知到服务端
     */
    $notifyUrls = empty($notify_url) ? config('game-server.payNotifyServerList') : $notify_url;

    dispatch(new \Someline\Jobs\PostDateToGameServer($postData, $notifyUrls));
});
