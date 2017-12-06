<?php

namespace App\Services;

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

    public function updateCompanyMarketPrice(int $companyMarketId, float $price): void
    {
        $this->entityManager->createQuery('UPDATE  \\App\\Entity\\CompanyMarket companyMarket SET 
          companyMarket.price = :price, companyMarket.priceUpdatedAt = :priceUpdatedAt
          WHERE companyMarket.id = :id
          ')
            ->setParameter('priceUpdatedAt', new \DateTime())
            ->setParameter('id', $companyMarketId)
            ->setParameter('price', $price)
            ->execute();
    }
}
