<?php

include_once 'BaseApiTestCase.php';

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SmsTest extends BaseApiTestCase
{
    /**
     * Test Send Code
     */
    public function testSend()
    {
        $this->withOAuthTokenTypePassword();
        $this->postApi('sms/code', ['mobile' => 17091312110]);
        $this->assertResponseOk();

        $this->printResponseData();
        $this->seeJsonStructure([
            "status_code",
            "message"
        ]);
    }

    /**
     * SMS verify
     */
    public function testVerify()
    {
        $this->withOAuthTokenTypePassword();
        $this->postApi('sms/verify', ['mobile' => 17091312110, 'verifyCode' => 12345]);
        $this->assertResponseStatus(422);

        $this->printResponseData();
        $this->seeJsonStructure([
            "status_code",
            "message"
        ]);

    }

    /**
     *  reset password by mobile
     */
    public function testResetPassword()
    {
        $this->withOAuthTokenTypePassword();
        $this->postApi('sms/password-reset', ['mobile' => 17091312110]);
        $this->assertResponseOk();

        $this->printResponseData();
        $this->seeJsonStructure([
            "status_code",
            "message"
        ]);

    }

    /**
     *  Verifiy sms code
     */
    public function testVerifyRestPassword()
    {
        $this->withOAuthTokenTypePassword();
        $this->postApi('sms/password-verify', ['mobile' => 17091312110, 'verifyCode' => 55291, 'password' => 123456]);
        $this->assertResponseStatus(422);

        $this->printResponseData();
        $this->seeJsonStructure([
            "status_code",
            "message"
        ]);

    }

    /**
     *  unbind user mobile
     */
    public function testUnbindMobile()
    {
        $this->withOAuthTokenTypePassword();

        $this->postApi('sms/code', []);

        $this->postApi('sms/unbind', ['mobile' => 17091312110, 'verifyCode' => '000000']);

        $this->printResponseData();
        $this->seeJsonStructure([
            "status_code",
            "message"
        ]);

    }


}
