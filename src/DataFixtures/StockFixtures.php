<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Stock;
use App\Entity\Market;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class StockFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var Stock[]|array
     */
    private $stocks;

    public function load(ObjectManager $manager): void
    {
        $market1 = $this->getReference('market_1');
        $market2 = $this->getReference('market_2');
        $market3 = $this->getReference('market_3');
        $company1 = $this->getReference('company_1');
        $company2 = $this->getReference('company_2');

        $this->addStock($market1, $company1, Stock::TYPE_COMMON);
        $this->addStock($market1, $company1, Stock::TYPE_PREFERRED);
        $this->addStock($market2, $company1, Stock::TYPE_PREFERRED);
        $this->addStock($market3, $company1, Stock::TYPE_PREFERRED);
        $this->addStock($market1, $company2, Stock::TYPE_COMMON);
        $this->addStock($market2, $company2, Stock::TYPE_COMMON);
        $this->addStock($market3, $company2, Stock::TYPE_COMMON);

        foreach ($this->stocks as $stock) {
            $manager->persist($stock);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            MarketFixtures::class,
            CompanyFixtures::class,
        ];
    }

    private function addStock(Market $market, Company $company, $type)
    {
        $stock = new Stock();
        $stock->setMarket($market)
            ->setCompany($company)
            ->setType($type)
            ->setPrice(random_int(10, 15))
        ;

        $this->stocks[] = $stock;
    }
}
