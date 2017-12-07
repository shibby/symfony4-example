<?php

namespace App\Services;

use App\Entity\Company;
use App\Entity\Stock;
use Doctrine\ORM\EntityManagerInterface;

class StockService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getStock(int $stockId): ?Stock
    {
        return $this->entityManager->getRepository('App:Stock')
            ->find($stockId);
    }

    public function updateStockPrice(Stock $stock, float $price): void
    {
        if ($stock->getPrice() !== $price) {
            $stock->setPrice($price)
                ->setPriceUpdatedAt(new \DateTime());
            $this->entityManager->persist($stock);
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
                    $stock = new Stock();
                    $stock->setMarket($market)
                        ->setCompany($company)
                        ->setType($type);
                    $this->entityManager->persist($stock);
                }
            }
        }
        $this->entityManager->flush();
    }
}
