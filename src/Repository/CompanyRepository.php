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

    public function findCompaniesWithStocks(): ?array
    {
        return $this->createQueryBuilder('company')
            ->select([
                'company',
                'stocks',
                'market',
            ])
            ->leftJoin('company.stocks', 'stocks')
            ->leftJoin('stocks.market', 'market')
            ->getQuery()
            ->getResult();
    }
}
