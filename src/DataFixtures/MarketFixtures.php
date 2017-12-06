<?php

namespace App\DataFixtures;

use App\Entity\Market;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class MarketFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = $this->getDummyData();

        $i = 1;
        foreach ($data as $datum) {
            $market = new Market();
            $market->setName($datum['name']);

            $manager->persist($market);
            if ($i < 4) {
                //for first 3 market, i'm adding them as reference to use future
                $manager->flush();
                $this->addReference('market_'.$i, $market);
            }
            ++$i;
        }
        $manager->flush();
    }

    private function getDummyData(): array
    {
        return [
            [
                'name' => 'New York Stock Exchange',
            ],
            [
                'name' => 'London Stock Exchange',
            ],
            [
                'name' => 'Hong Kong Stock Exchange',
            ],
            [
                'name' => 'Shanghai Stock Exchange',
            ],
            [
                'name' => 'Deutsche Börse Frankfurt',
            ],
        ];
    }

    public function getDependencies(): array
    {
        return [
        ];
    }
}
