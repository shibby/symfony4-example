<?php

namespace App\Services;

use App\Entity\Company;
use App\Entity\CompanyMarket;
use Doctrine\ORM\EntityManagerInterface;

class CompanyMarketService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getCompanyMarket(int $companyMarketId): ?CompanyMarket
    {
        return $this->entityManager->getRepository('App:CompanyMarket')
            ->find($companyMarketId);
    }

    public function updateCompanyMarketPrice(CompanyMarket $companyMarket, float $price): void
    {
        if ($companyMarket->getPrice() !== $price) {
            $companyMarket->setPrice($price)
                ->setPriceUpdatedAt(new \DateTime());
            $this->entityManager->persist($companyMarket);
            $this->entityManager->flush();
        }
    }

    public function addStocks(Company $company, array $stocks)
    {
        /**
         * @var int
         * @var array $types
         */
        foreach ($stocks as $marketId => $types) {
            $market = $this->entityManager->getRepository('App:Market')
                ->find($marketId);
            if ($market) {
                foreach ($types as $type) {
                    $companyMarket = new CompanyMarket();
                    $companyMarket->setMarket($market)
                        ->setCompany($company)
                        ->setType($type);
                    $this->entityManager->persist($companyMarket);
                }
            }
        }
        $this->entityManager->flush();
    }
}
