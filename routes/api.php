<?php

use Dingo\Api\Routing\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// v1
$api->version('v1', [
    'namespace' => 'Someline\Api\Controllers',
    'middleware' => ['api']
], function (Router $api) {

    $api->group(['prefix' => 'orders'], function (Router $api) {

        $api->post('verify/{type}', 'OrdersController@verify');
        $api->post('verify-apple/{sanbox}', 'OrdersController@verifyApplePay');

    });

    //SMS no auth
    $api->group(['prefix' => 'sms'], function (Router $api) {
        //$api->get('','SMSController@send') ;
        $api->post('code', 'SMSController@send');
        $api->post('verify', 'SMSController@verify');
        $api->post('password-reset', 'SMSController@resetPassword');
        $api->post('password-verify', 'SMSController@verifyRestPassword');
        $api->post('mobile-login-verify', 'SMSController@verifyMobileLogin');

    });
    
    // Rate: 100 requests per 5 minutes
    $api->group(['middleware' => ['api.throttle'], 'limit' => 100, 'expires' => 5], function (Router $api) {
        $api->post('users', 'UsersController@store');

        //登录注册合并
        $api->post('users/merge', 'UsersController@loginMerge');
        //根据设备版本返回后台配置
        $api->get('publications', 'PublicationsController@index');

        // 所有版本公共配置信息
        $api->group(['prefix' => 'config'], function (Router $api) {
            $api->get('/qiniu', function () {
                $disk = \Storage::disk('qiniu');
                $data['base_url'] = config('filesystems.disks.qiniu.domains.custom') ?: config('filesystems.disks.qiniu.domains.default');
                $data['upload_token'] = $disk->uploadToken();
                return $data;
            });
            $api->get('/geoip', function () {
                $location = \GeoIP::getLocation(request('ip'));
                return $location;
            });


        });

        
    }) ;

    $api->group(['middleware' => ['auth:api'],], function (Router $api) {

        // Rate: 100 requests per 5 minutes
        $api->group(['middleware' => ['api.throttle'], 'prefix' => 'users', 'limit' => 100, 'expires' => 5], function (Router $api) {

            $api->get('/', 'UsersController@index');

            //$api->post('users', 'UsersController@store');

            $api->get('me', 'UsersController@me');

            $api->get('{id}', 'UsersController@show');

            $api->put('{id}', 'UsersController@update');

            $api->delete('{id}', 'UsersController@destroy');

            //更新密码
            $api->post('password-rest', 'UsersController@restPassword');


        });

        //Orders
        $api->group(['prefix' => 'orders'], function (Router $api) {

            $api->get('', 'OrdersController@index');
            $api->post('', 'OrdersController@store');
            //$api->post('verify/{type}', 'OrdersController@verify');

            $api->get('/{id}', 'OrdersController@show');

            $api->put('/{id}', 'OrdersController@update');

            $api->delete('/{id}', 'OrdersController@destroy');

        });

        //game_pays
        $api->group(['prefix' => 'pays'], function (Router $api) {

            $api->get('', 'PaysController@index');
            $api->post('', 'PaysController@store');

            $api->get('/{id}', 'PaysController@show');

            $api->put('/{id}', 'PaysController@update');

            $api->delete('/{id}', 'PaysController@destroy');

        });

        $api->group(['prefix' => 'sms'], function (Router $api) {
            $api->post('bind', 'SMSController@bind');
            $api->post('unbind', 'SMSController@unbind');
        });
        //活动
        $api->group(['prefix' => 'activities'], function (Router $api) {
            $api->post('good_reputation', 'ActivitiesController@goodReputation');
            $api->get('good_reputation', 'ActivitiesController@getGoodReputation');
            $api->get('good_reputation_award', 'ActivitiesController@getGoodReputationAward');
        });

    });


});