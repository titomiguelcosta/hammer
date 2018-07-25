<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GitHubControllerTest extends WebTestCase
{
    public function testShowPost()
    {
        $client = static::createClient();
        
        $client->request('GET', '/v1/github/user');

        $this->assertContains('tito', $client->getResponse()->getContent());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
