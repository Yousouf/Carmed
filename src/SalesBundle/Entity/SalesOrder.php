<?php

namespace SalesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SalesOrder
 *
 * @ORM\Table(name="sales_order")
 * @ORM\Entity(repositoryClass="SalesBundle\Repository\SalesOrderRepository")
 */
class SalesOrder
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
     * @ORM\Column(name="id_customer", type="integer")
     */
    private $idCustomer;

    /**
     * @var int
     *
     * @ORM\Column(name="id_user", type="integer")
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=255)
     */
    private $mobile;

    /**
     * @var string
     *
     * @ORM\Column(name="delivery_address", type="text")
     */
    private $deliveryAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="invoice_address", type="text")
     */
    private $invoiceAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="payment", type="string", length=255)
     */
    private $payment;

    /**
     * @var string
     *
     * @ORM\Column(name="carrier", type="string", length=255)
     */
    private $Carrier;

    /**
     * @var string
     *
     * @ORM\Column(name="cost_carrier", type="decimal", precision=10, scale=3)
     */
    private $costCarrier;

    /**
     * @var string
     *
     * @ORM\Column(name="total_tax_exl", type="decimal", precision=10, scale=3)
     */
    private $totalTaxExl;

    /**
     * @var string
     *
     * @ORM\Column(name="total_tax_incl", type="decimal", precision=10, scale=3)
     */
    private $totalTaxIncl;

    /**
     * @var string
     *
     * @ORM\Column(name="total_paid", type="decimal", precision=10, scale=3)
     */
    private $totalpaid;

    /**
     * @var string
     *
     * @ORM\Column(name="total_tax", type="decimal", precision=10, scale=3)
     */
    private $totalTax;

    /**
     * @var string
     *
     * @ORM\Column(name="marge", type="decimal", precision=10, scale=3)
     */
    private $marge;

    /**
     * @var string
     *
     * @ORM\Column(name="discount", type="decimal", precision=10, scale=3)
     */
    private $discount;
    
    /**
     * @var int
     *
     * @ORM\Column(name="invoice_number", type="integer")
     */
    private $invoiceNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_add", type="datetime")
     */
    private $dateAdd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_invoice", type="datetime")
     */
    private $dateInvoice;

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
     * Set idCustomer.
     *
     * @param int $idCustomer
     *
     * @return SalesOrder
     */
    public function setIdCustomer($idCustomer)
    {
        $this->idCustomer = $idCustomer;

        return $this;
    }

    /**
     * Get idCustomer.
     *
     * @return int
     */
    public function getIdCustomer()
    {
        return $this->idCustomer;
    }

    /**
     * Set idUser.
     *
     * @param int $idUser
     *
     * @return SalesOrder
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
     * Set firstname.
     *
     * @param string $firstname
     *
     * @return SalesOrder
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname.
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname.
     *
     * @param string $lastname
     *
     * @return SalesOrder
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname.
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set mobile.
     *
     * @param string $mobile
     *
     * @return SalesOrder
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile.
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set deliveryAddress.
     *
     * @param string $deliveryAddress
     *
     * @return SalesOrder
     */
    public function setDeliveryAddress($deliveryAddress)
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    /**
     * Get deliveryAddress.
     *
     * @return string
     */
    public function getDeliveryAddress()
    {
        return $this->deliveryAddress;
    }

    /**
     * Set invoiceAddress.
     *
     * @param string $invoiceAddress
     *
     * @return SalesOrder
     */
    public function setInvoiceAddress($invoiceAddress)
    {
        $this->invoiceAddress = $invoiceAddress;

        return $this;
    }

    /**
     * Get invoiceAddress.
     *
     * @return string
     */
    public function getInvoiceAddress()
    {
        return $this->invoiceAddress;
    }

    /**
     * Set payment.
     *
     * @param string $payment
     *
     * @return SalesOrder
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * Get payment.
     *
     * @return string
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set carrier.
     *
     * @param string $carrier
     *
     * @return SalesOrder
     */
    public function setCarrier($carrier)
    {
        $this->Carrier = $carrier;

        return $this;
    }

    /**
     * Get carrier.
     *
     * @return string
     */
    public function getCarrier()
    {
        return $this->Carrier;
    }

    /**
     * Set costCarrier.
     *
     * @param string $costCarrier
     *
     * @return SalesOrder
     */
    public function setCostCarrier($costCarrier)
    {
        $this->costCarrier = $costCarrier;

        return $this;
    }

    /**
     * Get costCarrier.
     *
     * @return string
     */
    public function getCostCarrier()
    {
        return $this->costCarrier;
    }

    /**
     * Set totalTaxExl.
     *
     * @param string $totalTaxExl
     *
     * @return SalesOrder
     */
    public function setTotalTaxExl($totalTaxExl)
    {
        $this->totalTaxExl = $totalTaxExl;

        return $this;
    }

    /**
     * Get totalTaxExl.
     *
     * @return string
     */
    public function getTotalTaxExl()
    {
        return $this->totalTaxExl;
    }

    /**
     * Set totalTaxIncl.
     *
     * @param string $totalTaxIncl
     *
     * @return SalesOrder
     */
    public function setTotalTaxIncl($totalTaxIncl)
    {
        $this->totalTaxIncl = $totalTaxIncl;

        return $this;
    }

    /**
     * Get totalTaxIncl.
     *
     * @return string
     */
    public function getTotalTaxIncl()
    {
        return $this->totalTaxIncl;
    }

    /**
     * Set totalpaid.
     *
     * @param string $totalpaid
     *
     * @return SalesOrder
     */
    public function setTotalpaid($totalpaid)
    {
        $this->totalpaid = $totalpaid;

        return $this;
    }

    /**
     * Get totalpaid.
     *
     * @return string
     */
    public function getTotalpaid()
    {
        return $this->totalpaid;
    }

    /**
     * Set totalTax.
     *
     * @param string $totalTax
     *
     * @return SalesOrder
     */
    public function setTotalTax($totalTax)
    {
        $this->totalTax = $totalTax;

        return $this;
    }

    /**
     * Get totalTax.
     *
     * @return string
     */
    public function getTotalTax()
    {
        return $this->totalTax;
    }

    /**
     * Set invoiceNumber.
     *
     * @param int $invoiceNumber
     *
     * @return SalesOrder
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    /**
     * Get invoiceNumber.
     *
     * @return int
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * Set status.
     *
     * @param string $status
     *
     * @return SalesOrder
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set dateAdd.
     *
     * @param \DateTime $dateAdd
     *
     * @return SalesOrder
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
     * Set dateInvoice.
     *
     * @param \DateTime $dateInvoice
     *
     * @return SalesOrder
     */
    public function setDateInvoice($dateInvoice)
    {
        $this->dateInvoice = $dateInvoice;

        return $this;
    }

    /**
     * Get dateInvoice.
     *
     * @return \DateTime
     */
    public function getDateInvoice()
    {
        return $this->dateInvoice;
    }

    /**
     * Set dateUpd.
     *
     * @param \DateTime $dateUpd
     *
     * @return SalesOrder
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
     * Set marge.
     *
     * @param string $marge
     *
     * @return SalesOrder
     */
    public function setMarge($marge)
    {
        $this->marge = $marge;

        return $this;
    }

    /**
     * Get marge.
     *
     * @return string
     */
    public function getMarge()
    {
        return $this->marge;
    }

    /**
     * Set discount.
     *
     * @param string $discount
     *
     * @return SalesOrder
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount.
     *
     * @return string
     */
    public function getDiscount()
    {
        return $this->discount;
    }
}
