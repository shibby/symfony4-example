<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompanyRepository")
 */
class Company
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
     * @ORM\OneToMany(targetEntity="App\Entity\CompanyMarket", mappedBy="company")
     */
    private $markets;

    /**
     * @var array
     */
    private $marketsByType;

    /**
     * @return array
     */
    public function getMarketsByType(): ?array
    {
        return $this->marketsByType;
    }

    /**
     * @param int             $type
     * @param ArrayCollection $markets
     *
     * @return Company
     */
    public function setMarketsByType(int $type, ArrayCollection $markets): self
    {
        $this->marketsByType[$type] = $markets;

        return $this;
    }

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
     * @return Company
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getMarkets(): ?Collection
    {
        return $this->markets;
    }

    /**
     * @param CompanyMarket[] $companyMarkets
     *
     * @return Company
     */
    public function setMarkets($companyMarkets): self
    {
        $this->markets = $companyMarkets;

        return $this;
    }
}
