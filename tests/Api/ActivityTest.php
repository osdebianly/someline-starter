<?php

include_once 'BaseApiTestCase.php';

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ActivityTest extends BaseApiTestCase
{
    /**
     * 提交一个好评请求
     */
    public function testCreateGoodReputation()
    {
        $this->withOAuthTokenTypePassword();
        $this->postApi('activities/good_reputation', [
            'pic_url' => 'http://www.qq.com',
            'message' => '好评要过啊',
        ]);
        $this->printResponseData();
        $this->assertResponseOk();

        /**
         * 失败用例,url 不符合规则
         */
        $this->postApi('activities/good_reputation', [
            'pic_url' => 'www.qq.com',
            'message' => '好评要过啊',
        ]);
        $this->seeStatusCode(422);


    }

    /**
     * 获取一个好评请求
     */
    public function testGetGoodReputation()
    {
        $this->withOAuthTokenTypePassword();
        $this->getApi('activities/good_reputation');
        $this->printResponseData();
        $this->assertResponseOk();
        $this->seeJsonStructure([
            'note',
            'message',
            'state',
            'pic_url',
        ]);
    }

    /**
     * 领取好评奖励
     */
    public function testGetGoodReputationAward()
    {
        $this->withOAuthTokenTypePassword();
        $this->getApi('activities/good_reputation_award');
        $this->printResponseData();
        $this->seeStatusCode(422);
    }


}
