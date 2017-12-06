<?php

namespace App\Services;

use App\Entity\Company;
use App\Entity\CompanyMarket;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class HomepageService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getCompanies()
    {
        $companies = $this->entityManager->getRepository('App:Company')
            ->findCompaniesWithMarkets();

        array_walk($companies, function (&$company) {
            foreach (CompanyMarket::TYPES as $type => $value) {
                /** @var ArrayCollection $companyMarkets */
                $companyMarkets = $company->getMarkets()->filter(function ($q) use ($type) {
                    return $type === $q->getType();
                });
                if ($companyMarkets->count() > 0) {
                    $company->setMarketsByType($type, $companyMarkets);
                }
            }
        });

        return $companies;
    }
}
