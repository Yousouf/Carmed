<?php

namespace FabricationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductsFabrication
 *
 * @ORM\Table(name="products_fabrication")
 * @ORM\Entity(repositoryClass="FabricationBundle\Repository\ProductsFabricationRepository")
 */
class ProductsFabrication
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
     * @ORM\Column(name="reference", type="string", length=128, nullable=true)
     */
    private $reference;

    /**
     * @var float
     *
     * @ORM\Column(name="wholesale_price", type="decimal", precision=20, scale=6, nullable=true)
     */
    private $wholesale_price;

    /**
     * @var float
     *
     * @ORM\Column(name="tax", type="decimal", precision=10, scale=3, nullable=true)
     */
    private $tax;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;
	
	/**
     * @var string
     *
     * @ORM\Column(name="unit", type="string", length=128, nullable=true)
     */
    private $unit;
	
	 /**
     * @var int
     *
     * @ORM\Column(name="emballage", type="smallint")
     */
    private $emballage;

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
     * @return ProductsFabrication
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
     * Set unit.
     *
     * @param string $unit
     *
     * @return ProductsFabrication
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit.
     *
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set type.
     *
     * @param string $type
     *
     * @return ProductsFabrication
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set dateAdd.
     *
     * @param \DateTime $dateAdd
     *
     * @return ProductsFabrication
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
     * @param \DateTime $dateUpd
     *
     * @return ProductsFabrication
     */
    public function setDateUpd($dateUpd)
    {
        $this->dateUpd = $dateUpd;

        return $this;
    }

    /**
     * Get dateUpd.
     *
     * @return \DateTime
     */
    public function getDateUpd()
    {
        return $this->dateUpd;
    }

    /**
     * Set reference.
     *
     * @param string|null $reference
     *
     * @return ProductsFabrication
     */
    public function setReference($reference = null)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference.
     *
     * @return string|null
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set wholesalePrice.
     *
     * @param string|null $wholesalePrice
     *
     * @return ProductsFabrication
     */
    public function setWholesalePrice($wholesalePrice = null)
    {
        $this->wholesale_price = $wholesalePrice;

        return $this;
    }

    /**
     * Get wholesalePrice.
     *
     * @return string|null
     */
    public function getWholesalePrice()
    {
        return $this->wholesale_price;
    }

    /**
     * Set tax.
     *
     * @param string|null $tax
     *
     * @return ProductsFabrication
     */
    public function setTax($tax = null)
    {
        $this->tax = $tax;

        return $this;
    }
    /**
     * Get tax.
     *
     * @return string|null
     */
    public function getTax()
    {
        return $this->tax;
    }
	
	 /**
     * Set emballage.
     *
     * @param int $emballage
     *
     * @return ProductsFabrication
     */
    public function setEmballage($emballage)
    {
        $this->emballage = $emballage;

        return $this;
    }

    /**
     * Get emballage.
     *
     * @return int
     */
    public function getEmballage()
    {
        return $this->emballage;
    }
}
