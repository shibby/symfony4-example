<?php

namespace App\Repository;

use App\Entity\Company;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CompanyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Company::class);
    }

    public function findCompaniesWithMarkets(): ?array
    {
        return $this->createQueryBuilder('company')
            ->select([
                'company',
                'companyMarkets',
                'market',
            ])
            ->leftJoin('company.markets', 'companyMarkets')
            ->leftJoin('companyMarkets.market', 'market')
            ->getQuery()
            ->getResult();
    }
}
