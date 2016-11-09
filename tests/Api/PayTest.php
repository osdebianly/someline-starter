<?php

include_once 'BaseApiTestCase.php';

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PayTest extends BaseApiTestCase
{


    public function testGetAllPay()
    {
        $this->withOAuthTokenTypePassword();
        $this->getApi('pays');
        $this->printResponseData();
        $this->seeJsonStructure([
            'data' => [
                '*' => [
                    'pay_id',
                    'number',
                    'created_at',
                ],
            ]
        ]);
    }


    public function testGetSinglePay()
    {
        $this->withOAuthTokenTypePassword();
        $this->getApi('pays/1');
        $this->printResponseData();
        $this->assertResponseOk();
        $this->seeJsonStructure([
            'data' => [
                'pay_id',
                'number',
                'created_at'
            ]
        ]);
    }

    public function testCreatePay()
    {
        $this->withOAuthTokenTypePassword();

        $this->postApi('pays', [
            'number' => '100',
            'note' => rand(100000, 999999) . 'abc@example.com',
        ]);
        $this->printResponseData();
        $this->assertResponseOk();
        $this->seeJsonStructure([
            'data' => [
                'pay_id',
                'number',
                'created_at'
            ]
        ]);
    }


    public function testUpdatePay()
    {
        $this->withOAuthTokenTypePassword();
        $this->putApi('pays/1', [
            'verify_code' => '1111',
            'note' => 'Test update',
        ]);
        $this->printResponseData();
        $this->assertResponseOk();
        //$this->assertResponseNoContent();
    }


    public function testDeletePost()
    {
        $pay = Someline\Models\Foundation\Pay::find(1);
        if (!$pay) {
            $pay = factory(Someline\Models\Foundation\Pay::class)->make();
            dd($pay);
            $pay->id = 1;
            $pay->save();
        }

        $this->withOAuthTokenTypePassword();
        $this->deleteApi('pays/1');
        $this->printResponseData();
        $this->seeJsonStructure([
            'message',
            'deleted',
        ]);
        //$this->assertResponseNoContent();
    }

}
