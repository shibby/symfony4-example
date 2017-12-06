<?php

namespace App\Services;

use App\Entity\Company;
use Doctrine\ORM\EntityManagerInterface;

class CompanyService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getCompany(int $id): ?Company
    {
        return $this->entityManager->getRepository('App:Company')
            ->find($id);
    }

    public function getCompanyMarkets(Company $company, $type = null): ?array
    {
        return $this->entityManager->getRepository('App:CompanyMarket')
            ->findCompanyMarkets($company, $type);
    }
}
