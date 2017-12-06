<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CompanyUpdatePriceTest extends WebTestCase
{
    public function testGetPricesPage()
    {
        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine.orm.default_entity_manager');

        $companies = $entityManager->getRepository('App:Company')
                ->findAll();

        foreach ($companies as $company) {
            $crawler = $client->request('GET', '/company/'.$company->getId().'/update-prices/1');
            $this->assertSame(200, $client->getResponse()->getStatusCode());
            $this->assertCount(1, $crawler->filter('html:contains("'.$company->getName().'")'));

            $crawler = $client->request('POST', '/company/'.$company->getId().'/update-prices/1', [
            ]);
            $this->assertSame(302, $client->getResponse()->getStatusCode());
            //TODO: this should give validation error normally but i don't validate requests

            $crawler = $client->request('POST', '/company/'.$company->getId().'/update-prices/1', [
                'prices' => [
                    1 => 10,
                    2 => 5,
                    3 => 7,
                ],
            ]);
            $this->assertSame(302, $client->getResponse()->getStatusCode());
            //TODO: in this test,keys 1,2,3 couldn't be belongs to company#1.
        }
    }
}
