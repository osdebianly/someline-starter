<?php

include_once 'BaseApiTestCase.php';

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderTest extends BaseApiTestCase
{


    /**
     * 测试生成订单
     *
     */

    public function testStoreNoPay()
    {
        $this->withOAuthTokenTypePassword();
        $this->postApi('orders', [
            'title' => '10',
            'price' => '10',
            'note' => 'this is a test order',
            'pay_type' => 'alipay_app',
            'no_pay' => 1,
        ]);

        $this->printResponseData();
        $this->seeJsonStructure([
            'data'=>['id','price','created_at'],
        ]);
    }




}
