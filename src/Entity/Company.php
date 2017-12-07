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
     * @ORM\OneToMany(targetEntity="App\Entity\Stock", mappedBy="company")
     */
    private $stocks;

    /**
     * @var array
     */
    private $stocksByType;

    /**
     * @return array
     */
    public function getStocksByType(): ?array
    {
        return $this->stocksByType;
    }

    /**
     * @param int             $type
     * @param ArrayCollection $stocks
     *
     * @return Company
     */
    public function setStocksByType(int $type, ArrayCollection $stocks): self
    {
        $this->stocksByType[$type] = $stocks;

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
    public function getStocks(): ?Collection
    {
        return $this->stocks;
    }

    /**
     * @param Stock[] $stocks
     *
     * @return Company
     */
    public function setStocks($stocks): self
    {
        $this->stocks = $stocks;

        return $this;
    }
}
