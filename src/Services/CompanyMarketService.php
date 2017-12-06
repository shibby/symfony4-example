<?php

namespace App\Services;

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
}
