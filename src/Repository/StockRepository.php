<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\Stock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class StockRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Stock::class);
    }

    public function findStocks(?Company $company, ?int $type)
    {
        $queryBuilder = $this->createQueryBuilder('stock')
            ->select('stock', 'market')
            ->join('stock.market', 'market');
        if (null !== $company) {
            $queryBuilder->andWhere('stock.company = :company')
                ->setParameter('company', $company);
        }
        if (null !== $type) {
            $queryBuilder->andWhere('stock.type = :type')
                ->setParameter('type', $type);
        }

        return $queryBuilder->getQuery()
            ->getResult();
    }
}
