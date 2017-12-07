<?php

namespace App\Services;

use App\Entity\Company;
use App\Entity\Stock;
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
            ->findCompaniesWithStocks();

        array_walk($companies, function (&$company) {
            foreach (Stock::TYPES as $type => $value) {
                /** @var ArrayCollection $stocks */
                $stocks = $company->getStocks()->filter(function ($q) use ($type) {
                    return $type === $q->getType();
                });
                if ($stocks->count() > 0) {
                    $company->setStocksByType($type, $stocks);
                }
            }
        });

        return $companies;
    }
}
