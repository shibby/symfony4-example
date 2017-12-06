<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompanyMarketRepository")
 */
class CompanyMarket
{
    public const TYPES = [
        1 => 'Common',
        2 => 'Preferred',
    ];
    public const TYPE_COMMON = 1;
    public const TYPE_PREFERRED = 2;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company", inversedBy="markets")
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Market", inversedBy="companies")
     */
    private $market;

    /**
     * @ORM\Column(type="float", precision=2, nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $priceUpdatedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     *
     * @return CompanyMarket
     */
    public function setCompany($company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMarket()
    {
        return $this->market;
    }

    /**
     * @param mixed $market
     *
     * @return CompanyMarket
     */
    public function setMarket($market)
    {
        $this->market = $market;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     *
     * @return CompanyMarket
     */
    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     *
     * @return CompanyMarket
     */
    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPriceUpdatedAt(): ?\DateTimeInterface
    {
        return $this->priceUpdatedAt;
    }

    /**
     * @param \DateTimeInterface $priceUpdatedAt
     *
     * @return CompanyMarket
     */
    public function setPriceUpdatedAt(\DateTimeInterface $priceUpdatedAt): self
    {
        $this->priceUpdatedAt = $priceUpdatedAt;

        return $this;
    }
}
