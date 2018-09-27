<?php

namespace FabricationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FabricationInventary
 *
 * @ORM\Table(name="fabrication_inventary")
 * @ORM\Entity(repositoryClass="FabricationBundle\Repository\FabricationInventaryRepository")
 */
class FabricationInventary
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
     * @var int
     *
     * @ORM\Column(name="id_product", type="integer")
     */
    private $idProduct;

    /**
     * @var int
     *
     * @ORM\Column(name="entree", type="integer")
     */
    private $entree;

    /**
     * @var int
     *
     * @ORM\Column(name="sortie", type="integer")
     */
    private $sortie;

	/**
     * @var int
     *
     * @ORM\Column(name="rest", type="integer")
     */
    private $rest;
	
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

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
     * Set idProduct.
     *
     * @param int $idProduct
     *
     * @return FabricationInventary
     */
    public function setIdProduct($idProduct)
    {
        $this->idProduct = $idProduct;

        return $this;
    }

    /**
     * Get idProduct.
     *
     * @return int
     */
    public function getIdProduct()
    {
        return $this->idProduct;
    }

    /**
     * Set entree.
     *
     * @param int $entree
     *
     * @return FabricationInventary
     */
    public function setEntree($entree)
    {
        $this->entree = $entree;

        return $this;
    }

    /**
     * Get entree.
     *
     * @return int
     */
    public function getEntree()
    {
        return $this->entree;
    }

    /**
     * Set sortie.
     *
     * @param int $sortie
     *
     * @return FabricationInventary
     */
    public function setSortie($sortie)
    {
        $this->sortie = $sortie;

        return $this;
    }

    /**
     * Get sortie.
     *
     * @return int
     */
    public function getSortie()
    {
        return $this->sortie;
    }

    /**
     * Set sortie.
     *
     * @param int $sortie
     *
     * @return FabricationInventary
     */
    public function setRest($rest)
    {
        $this->rest = $rest;

        return $this;
    }

    /**
     * Get sortie.
     *
     * @return int
     */
    public function getRest()
    {
        return $this->rest;
    }
    
    /**
     * Set name.
     *
     * @param string $name
     *
     * @return FabricationInventary
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
     * Set dateAdd.
     *
     * @param \DateTime $dateAdd
     *
     * @return FabricationInventary
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
     * @return FabricationInventary
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
}
