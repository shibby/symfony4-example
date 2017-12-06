<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\CompanyMarket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CompanyMarketRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CompanyMarket::class);
    }

    public function findCompanyMarkets(?Company $company, ?int $type)
    {
        $queryBuilder = $this->createQueryBuilder('companyMarket')
            ->select('companyMarket', 'market')
            ->join('companyMarket.market', 'market');
        if (null !== $company) {
            $queryBuilder->andWhere('companyMarket.company = :company')
                ->setParameter('company', $company);
        }
        if (null !== $type) {
            $queryBuilder->andWhere('companyMarket.type = :type')
                ->setParameter('type', $type);
        }

        return $queryBuilder->getQuery()
            ->getResult();
    }
}
