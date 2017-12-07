<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;

class MarketService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getMarkets()
    {
        return $this->entityManager->getRepository('App:Market')
            ->findAll();
    }
}
