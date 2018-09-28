<?php

namespace SalesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SalesProduct
 *
 * @ORM\Table(name="sales_product")
 * @ORM\Entity(repositoryClass="SalesBundle\Repository\SalesProductRepository")
 */
class SalesProduct
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="short_description", type="string", length=255)
     */
    private $shortDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="sku", type="string", length=255)
     */
    private $sku;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=6, scale=3)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="tax", type="decimal", precision=4, scale=2)
     */
    private $tax;

    /**
     * @var int
     *
     * @ORM\Column(name="use_tax", type="smallint")
     */
    private $useTax;

    /**
     * @var string
     *
     * @ORM\Column(name="promo", type="decimal", precision=4, scale=2)
     */
    private $promo;

    /**
     * @var int
     *
     * @ORM\Column(name="enable_promo", type="smallint")
     */
    private $enablePromo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_add", type="datetime")
     */
    private $dateAdd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_upd", type="datetime")
     */
    private $dateUpd;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return SalesProduct
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return SalesProduct
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set shortDescription.
     *
     * @param string $shortDescription
     *
     * @return SalesProduct
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * Get shortDescription.
     *
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Set sku.
     *
     * @param string $sku
     *
     * @return SalesProduct
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Get sku.
     *
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Set price.
     *
     * @param string $price
     *
     * @return SalesProduct
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set status.
     *
     * @param int $status
     *
     * @return SalesProduct
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set tax.
     *
     * @param string $tax
     *
     * @return SalesProduct
     */
    public function setTax($tax)
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * Get tax.
     *
     * @return string
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Set useTax.
     *
     * @param int $useTax
     *
     * @return SalesProduct
     */
    public function setUseTax($useTax)
    {
        $this->useTax = $useTax;

        return $this;
    }

    /**
     * Get useTax.
     *
     * @return int
     */
    public function getUseTax()
    {
        return $this->useTax;
    }

    /**
     * Set promo.
     *
     * @param string $promo
     *
     * @return SalesProduct
     */
    public function setPromo($promo)
    {
        $this->promo = $promo;

        return $this;
    }

    /**
     * Get promo.
     *
     * @return string
     */
    public function getPromo()
    {
        return $this->promo;
    }

    /**
     * Set enablePromo.
     *
     * @param int $enablePromo
     *
     * @return SalesProduct
     */
    public function setEnablePromo($enablePromo)
    {
        $this->enablePromo = $enablePromo;

        return $this;
    }

    /**
     * Get enablePromo.
     *
     * @return int
     */
    public function getEnablePromo()
    {
        return $this->enablePromo;
    }

    /**
     * Set dateAdd.
     *
     * @param \DateTime $dateAdd
     *
     * @return Fournisseur
     */
    public function setDateAdd($dateAdd)
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    /**
     * Get dateAdd.
     *
     * @return \DateTime
     */
    public function getDateAdd()
    {
        return $this->dateAdd;
    }

    /**
     * Set dateUpd.
     *
     * @param string $dateUpd
     *
     * @return Fournisseur
     */
    public function setDateUpd($dateUpd)
    {
        $this->dateUpd = $dateUpd;

        return $this;
    }

    /**
     * Get dateUpd.
     *
     * @return string
     */
    public function getDateUpd()
    {
        return $this->dateUpd;
    }
}
