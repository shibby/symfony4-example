<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CompanyCreateTest extends WebTestCase
{
    public function testSomething()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/company/create');

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        //TODO: see all markets in form
        //TODO: submit form without a name
        //TODO: submit form without choosing any market
        //TODO: submit form with passing validation. And see from database that company and stocks created.
        //TODO: see that page is redirecting to update-prices page after company created.
    }
}
