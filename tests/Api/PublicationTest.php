<?php

include_once 'BaseApiTestCase.php';

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PublicationTest extends BaseApiTestCase
{
    /**
     * Test Send Code
     */
    public function testIndex()
    {
        $this->withOAuthTokenTypePassword();
        $this->get('publications', ['package_name' => 'abc', 'version' => '1.0', 'uuid' => 'abcd']);
        $this->assertResponseOk();

        $this->printResponseData();
        $this->seeJsonStructure([
            "publication_message",
            "online_config",
            "server_list",
            "hot_upgrade"
        ]);
    }


}
