<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MarketRepository")
 */
class Market
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompanyMarket", mappedBy="market")
     */
    private $companies;

    /**
     * @return mixed
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return Market
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getCompanies(): ?Collection
    {
        return $this->companies;
    }

    /**
     * @param CompanyMarket $companyMarket
     *
     * @return $this
     */
    public function setCompanies(CompanyMarket $companyMarket): self
    {
        $this->companies = $companyMarket;

        return $this;
    }
}
