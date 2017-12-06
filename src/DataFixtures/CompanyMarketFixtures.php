<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\CompanyMarket;
use App\Entity\Market;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CompanyMarketFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var CompanyMarket[]|array
     */
    private $companyMarkets;

    public function load(ObjectManager $manager): void
    {
        $market1 = $this->getReference('market_1');
        $market2 = $this->getReference('market_2');
        $market3 = $this->getReference('market_3');
        $company1 = $this->getReference('company_1');
        $company2 = $this->getReference('company_2');

        $this->addCompanyMarket($market1, $company1, CompanyMarket::TYPE_COMMON);
        $this->addCompanyMarket($market1, $company1, CompanyMarket::TYPE_PREFERRED);
        $this->addCompanyMarket($market2, $company1, CompanyMarket::TYPE_PREFERRED);
        $this->addCompanyMarket($market3, $company1, CompanyMarket::TYPE_PREFERRED);
        $this->addCompanyMarket($market1, $company2, CompanyMarket::TYPE_COMMON);
        $this->addCompanyMarket($market2, $company2, CompanyMarket::TYPE_COMMON);
        $this->addCompanyMarket($market3, $company2, CompanyMarket::TYPE_COMMON);

        foreach ($this->companyMarkets as $companyMarket) {
            $manager->persist($companyMarket);
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

    private function addCompanyMarket(Market $market, Company $company, $type)
    {
        $companyMarket = new CompanyMarket();
        $companyMarket->setMarket($market)
            ->setCompany($company)
            ->setType($type)
            ->setPrice(random_int(10, 15))
        ;

        $this->companyMarkets[] = $companyMarket;
    }
}
