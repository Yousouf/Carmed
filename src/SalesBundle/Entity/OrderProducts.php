<?php

namespace SalesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderProducts
 *
 * @ORM\Table(name="order_products")
 * @ORM\Entity(repositoryClass="SalesBundle\Repository\OrderProductsRepository")
 */
class OrderProducts
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
     * @ORM\Column(name="id_order", type="integer")
     */
    private $idOrder;

    /**
     * @var int
     *
     * @ORM\Column(name="id_product", type="integer")
     */
    private $idProduct;

    /**
     * @var string
     *
     * @ORM\Column(name="total_product", type="decimal", precision=10, scale=3)
     */
    private $totalProduct;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="unit_price", type="string", length=255)
     */
    private $unitPrice;


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
     * Set idOrder.
     *
     * @param int $idOrder
     *
     * @return OrderProducts
     */
    public function setIdOrder($idOrder)
    {
        $this->idOrder = $idOrder;

        return $this;
    }

    /**
     * Get idOrder.
     *
     * @return int
     */
    public function getIdOrder()
    {
        return $this->idOrder;
    }

    /**
     * Set idProduct.
     *
     * @param int $idProduct
     *
     * @return OrderProducts
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
     * Set totalProduct.
     *
     * @param string $totalProduct
     *
     * @return OrderProducts
     */
    public function setTotalProduct($totalProduct)
    {
        $this->totalProduct = $totalProduct;

        return $this;
    }

    /**
     * Get totalProduct.
     *
     * @return string
     */
    public function getTotalProduct()
    {
        return $this->totalProduct;
    }

    /**
     * Set quantity.
     *
     * @param int $quantity
     *
     * @return OrderProducts
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
     * Set name.
     *
     * @param string $name
     *
     * @return OrderProducts
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
     * Set unitPrice.
     *
     * @param string $unitPrice
     *
     * @return OrderProducts
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    /**
     * Get unitPrice.
     *
     * @return string
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }
}
