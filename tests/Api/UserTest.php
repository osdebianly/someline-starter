<?php

include_once 'BaseApiTestCase.php';

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends BaseApiTestCase
{

    public function testGetAllUsers()
    {
        $this->withOAuthTokenTypePassword();
        $this->getApi('users');
        $this->printResponseData();
        $this->seeJsonStructure([
            'data' => [
                '*' => [
                    'user_id',
                    'name',
                ],
            ]
        ]);
    }

    public function testGetCurrentUser()
    {
        $this->withOAuthTokenTypePassword();
        $this->getApi('users/me');
        $this->printResponseData();
        $this->assertResponseOk();
    }

    public function testGetSingleUser()
    {
        $this->withOAuthTokenTypePassword();
        $this->getApi('users/1');
        $this->assertResponseOk();
    }

    public function testCreateUser()
    {
        $this->withOAuthTokenTypePassword();
        $this->postApi('users', [
            'name' => 'Abc',
            'email' => rand(100000, 999999) . 'abc@example.com',
            'password' => '12345678',
        ]);
        $this->printResponseData();
        $this->assertResponseOk();
    }

    public function testUpdateUser()
    {
        $this->withOAuthTokenTypePassword();
        $this->putApi('users/2', [
            'name' => 'Harry Potter',
        ]);
        $this->printResponseData();
        $this->assertResponseNoContent();
    }

    public function testDeleteUser()
    {
        $user = \Someline\Models\Foundation\User::find(3);
        if (!$user) {
            $user = factory(\Someline\Models\Foundation\User::class, 1)->make();
            $user->user_id = 3;
            $user->save();
        }

        $this->withOAuthTokenTypePassword();
        $this->deleteApi('users/3');
        $this->printResponseData();
        $this->assertResponseNoContent();
    }

    public function testLoginMerge()
    {

        $this->postApi('users/merge', [
            'username' => 'lyfing',
            'password' => '123456',
            'uuid' => 'e4201f3f686b59a2068abd1f435f1684',
            'client_id' => '2',
            'client_secret' => 'FQPr3cy6vaYv1NYmFZHjUDD7XUfUxQk3ckALwOb0',
            'source' => 'test'
        ]);
        $this->printResponseData();
        $this->assertResponseOk();
        $this->seeJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
            'refresh_token'

        ]);
    }

    /**
     *  reset password by mobile
     */
    public function testResetPassword()
    {
        $this->withOAuthTokenTypePassword();

        $this->postApi('users/password-rest', ['old_password' => '123456', 'password' => '123456']);

        $this->printResponseData();
        $this->seeJsonStructure([
            "status_code",
            "message"
        ]);

    }

}
