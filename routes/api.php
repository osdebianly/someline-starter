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

    });
    
    // Rate: 100 requests per 5 minutes
    $api->group(['middleware' => ['api.throttle'], 'limit' => 100, 'expires' => 5], function (Router $api) {
        $api->post('users', 'UsersController@store');

        //登录注册合并
        $api->post('users/merge', 'UsersController@loginMerge');
        //获取通知
        $api->get('publications', 'PublicationsController@index');
        
    }) ;

    $api->group(['middleware' => ['auth:api']], function (Router $api) {

        // Rate: 100 requests per 5 minutes
        $api->group(['middleware' => ['api.throttle'], 'limit' => 100, 'expires' => 5], function (Router $api) {

            $api->get('users', 'UsersController@index');

            //$api->post('users', 'UsersController@store');

            $api->get('users/me', 'UsersController@me');

            $api->get('users/{id}', 'UsersController@show');

            $api->put('users/{id}', 'UsersController@update');

            $api->delete('users/{id}', 'UsersController@destroy');


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


    });


});