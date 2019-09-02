<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testShowHomepage()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testContainsWeatherCard()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertContains(
            'Today\'s weather for favourite cities',
            $client->getResponse()->getContent()
        );
    }
}

