<?php

include_once 'BaseApiTestCase.php';

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ActivityTest extends BaseApiTestCase
{

    public function testCreateGoodReputation()
    {
        $this->withOAuthTokenTypePassword();
        $this->postApi('activities/good_reputation', [
            'pic_url' => 'http://www.qq.com',
            'message' => '好评要过啊',
        ]);
        $this->printResponseData();

    }


}
