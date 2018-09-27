<?php

namespace FabricationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StockFabricationMovement
 *
 * @ORM\Table(name="stock_fabrication_movement")
 * @ORM\Entity(repositoryClass="FabricationBundle\Repository\StockFabricationMovementRepository")
 */
class StockFabricationMovement
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
     * @ORM\Column(name="id_user", type="integer")
     */
    private $idUser;

    /**
     * @var int
     *
     * @ORM\Column(name="id_fournisseur", type="integer")
     */
    private $idFournisseur;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="movement", type="string", length=255)
     */
    private $movement;

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
     * @return StockFabricationMovement
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
     * Set idUser.
     *
     * @param int $idUser
     *
     * @return StockFabricationMovement
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser.
     *
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }
	
    /**
     * Set idFournisseur.
     *
     * @param int $idFournisseur
     *
     * @return StockFabricationMovement
     */
    public function setIdFournisseur($idFournisseur)
    {
        $this->idFournisseur = $idFournisseur;

        return $this;
    }

    /**
     * Get idFournisseur.
     *
     * @return int
     */
    public function getIdFournisseur()
    {
        return $this->idFournisseur;
    }

    /**
     * Set quantity.
     *
     * @param int $quantity
     *
     * @return StockFabricationMovement
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity.
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set movement.
     *
     * @param string $movement
     *
     * @return StockFabricationMovement
     */
    public function setMovement($movement)
    {
        $this->movement = $movement;

        return $this;
    }

    /**
     * Get movement.
     *
     * @return string
     */
    public function getMovement()
    {
        return $this->movement;
    }

    /**
     * Set dateAdd.
     *
     * @param \DateTime $dateAdd
     *
     * @return StockFabricationMovement
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
     * @return StockFabricationMovement
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
