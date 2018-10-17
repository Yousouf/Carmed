<?php

namespace SalesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use SalesBundle\Entity\SalesOrder;
use SalesBundle\Entity\OrderProducts;
use SalesBundle\Classes\Nuts;

class OrdersController extends Controller
{

    public function __construct()
    {
        $session = new Session();
        if (!$session->has('cart')) {
            $session->set('cart', array());
        }
    }

    /**
     * @Route("/admin/sales/orders",name="admin_sales_orders")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
//print_r($this->generateUrl('admin_sales_getorders', array()));exit;
        return $this->render('SalesBundle:orders:index.html.twig');
    }

    /**
     * @Route("/admin/sales/orders/get",name="admin_sales_getorders")
     *
     * @Method({"POST","GET"})
     */
    public function getOrdersAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $order = $request->get('order');
        $column = array(1 => 'u.id', 2 => 'customer', 3 => 'u.totalpaid', 4 => 'u.dateAdd', 5 => 'product', 6 => 'u.status');
        $limit = (int)$request->get('length');
        $start = (int)$request->get('start');
        $desc = $order[0]['dir'];
        $orderBy = $column[(int)$order[0]['column']];//(int)$request->get('sortBy');
        $query = array();
        if ((string)$request->get('action') == 'filter') {
            ((int)$request->get('id') > 0) ? $query[] = 'u.id = ' . (int)$request->get('id') : '';
            ((string)$request->get('customer') != '') ? $query[] = "u.firstname LIKE '%" . (string)$request->get('customer') . "%'" : '';
        }


        $orders = $em->getRepository('SalesBundle:SalesOrder')->getOrders($limit, $start, $desc, $orderBy, $query);
        foreach ($orders['data'] as &$order) {
            $order[] = '<a href="javascript:;" class="btn btn-xs default btn-editable"><i class="fa fa-search"></i> Detail</a>'
                . '<a href="' . $this->generateUrl('admin_sales_orders_update', array('id' => $order[1])) . '" class="btn btn-xs default btn-editable"><i class="fa fa-edit"></i> Edit</a>'
                . '<a href="' . $this->generateUrl('admin_sales_orders_invoice', array('id' => $order[1])) . '" class="btn btn-xs default btn-editable"><i class="fa fa-print"></i> Facture</a>';
        }
        $orders["draw"] = $request->get('draw');

        return new JsonResponse($orders);
    }

    /**
     * @Route("/admin/sales/orders/add",name="admin_sales_orders_add")
     *
     * @Method({"POST","GET"})
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('SalesBundle:SalesProduct')->findAll();
        $payments = $em->getRepository('SalesBundle:PaymentMethod')->findAll();
        $carrier = $em->getRepository('SalesBundle:CarrierMethod')->findAll();
        $customer = $em->getRepository('SalesBundle:Customer')->findAll();
        $session = new Session();

        if ($request->getMethod() == 'POST') {

            $data = $session->get('cart');

            if (!empty($data)) {
                $order = new SalesOrder();

                $order->setIdCustomer((int)$request->get('id_customer'));
                $order->setIdUser((int)$this->getUser()->getId());
                $order->setFirstname((string)$request->get('firstname'));
                $order->setLastname((string)$request->get('lastname'));
                $order->setMobile((string)$request->get('mobile'));
                $order->setDeliveryAddress((string)$request->get('delivery_address'));
                $order->setInvoiceAddress((string)$request->get('invoice_address'));
                $order->setPayment((string)$data['payment']);
                $order->setCarrier((string)$data['carrier']['name']);
                $order->setCostCarrier((float)str_replace(' ', '', $data['carrier']['cost']));
                $order->setTotalTaxExl((float)str_replace(' ', '', $data['total_products']));
                $order->setMarge((float)str_replace(' ', '', $data['marge']));
                $order->setDiscount((float)str_replace(' ', '', $data['total_discount']));
                $order->setTotalTaxIncl(0);
                $order->setTotalpaid((float)str_replace(' ', '', $data['total']));
                $order->setTotalTax((float)str_replace(' ', '', $data['total_tax']));
                $order->setInvoiceNumber(0);
                $order->setStatus('');
                $order->setDateAdd(new \DateTime());
                $order->setDateInvoice(new \DateTime());
                $order->setDateUpd(new \DateTime());

                $em->persist($order);
                $em->flush($order);
                if (isset($data['products']) && !empty($data['products'])) {
                    foreach ($data['products'] as $product) {
                        $order_product = new OrderProducts();
                        $order_product->setIdOrder((int)$order->getId());
                        $order_product->setIdProduct((int)$product['id']);
                        $order_product->setTotalProduct((float)str_replace(' ', '', $product['total']));
                        $order_product->setQuantity((int)$product['quantity']);
                        $order_product->setName((string)$product['name']);
                        $order_product->setUnitPrice((float)str_replace(' ', '', $product['price']));
                        $em->persist($order_product);
                    }
                    $em->flush();
                }
            }


            if ((int)$request->get('save'))
                return $this->redirectToRoute('admin_sales_orders');
            elseif ((int)$request->get('save_edit'))
                return $this->redirectToRoute('admin_sales_orders_update', array('id' => $order->getId()));
        }

        // empty the cart session

        $session->set('cart', array());

        return $this->render('SalesBundle:orders:add.html.twig', array('title' => 'Ajouter une commande',
            'products' => $products,
            'payments' => $payments,
            'carrier' => $carrier,
            'customer' => $customer,
        ));
    }

    /**
     * @Route("/admin/sales/orders/update/{id}",name="admin_sales_orders_update")
     *
     * @Method({"POST","GET"})
     */
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('SalesBundle:SalesProduct')->findAll();
        $payments = $em->getRepository('SalesBundle:PaymentMethod')->findAll();
        $carrier = $em->getRepository('SalesBundle:CarrierMethod')->findAll();
        $customer = $em->getRepository('SalesBundle:Customer')->findAll();
        $session = new Session();
        $id_order = (int)$request->get('id');
        $payment = $current_carrier = '';
        $tax = 0;
        $data = $current_customer = array();
        $order = $em->getRepository('SalesBundle:SalesOrder')->findOneBy(array('id' => $id_order));

        if ($request->getMethod() == 'POST') {

            $data = $session->get('cart');

            if (!empty($data)) {
                //$order = new SalesOrder();

                $order->setIdCustomer((int)$request->get('id_customer'));
                $order->setIdUser((int)$this->getUser()->getId());
                $order->setFirstname((string)$request->get('firstname'));
                $order->setLastname((string)$request->get('lastname'));
                $order->setMobile((string)$request->get('mobile'));
                $order->setDeliveryAddress((string)$request->get('delivery_address'));
                $order->setInvoiceAddress((string)$request->get('invoice_address'));
                $order->setPayment((string)$data['payment']);
                $order->setCarrier((string)$data['carrier']['name']);
                $order->setCostCarrier((float)str_replace(' ', '', $data['carrier']['cost']));
                $order->setTotalTaxExl((float)str_replace(' ', '', $data['total_products']));
                $order->setMarge((float)str_replace(' ', '', $data['marge']));
                $order->setDiscount((float)str_replace(' ', '', $data['total_discount']));
                $order->setTotalTaxIncl(0);
                $order->setTotalpaid((float)str_replace(' ', '', $data['total']));
                $order->setTotalTax((float)str_replace(' ', '', $data['total_tax']));
                $order->setInvoiceNumber(0);
                $order->setStatus('');
                $order->setDateUpd(new \DateTime());

                $em->persist($order);
                $em->flush($order);
                if (isset($data['products']) && !empty($data['products'])) {
                    foreach ($data['products'] as $product) {
                        $order_product = $em->getRepository('SalesBundle:OrderProducts')->findOneBy(array('idOrder' => (int)$order->getId(), 'idProduct' => (int)$product['id']));

                        if (empty($order_product)) {
                            $order_product = new OrderProducts();
                            $order_product->setIdOrder((int)$order->getId());
                            $order_product->setIdProduct((int)$product['id']);
                        }

                        $order_product->setTotalProduct((float)str_replace(' ', '', $product['total']));
                        $order_product->setQuantity((int)$product['quantity']);
                        $order_product->setName((string)$product['name']);
                        $order_product->setUnitPrice((float)$product['price']);
                        $em->persist($order_product);
                    }
                    $em->flush();
                }
            }


            if ((int)$request->get('save'))
                return $this->redirectToRoute('admin_sales_orders');
            elseif ((int)$request->get('save_edit'))
                return $this->redirectToRoute('admin_sales_orders_update', array('id' => $order->getId()));
        } else {

            $current_customer['id_customer'] = $order->getIdCustomer();
            $current_customer['firstname'] = $order->getFirstname((string)$request->get('firstname'));
            $current_customer['lastname'] = $order->getLastname((string)$request->get('lastname'));
            $current_customer['mobile'] = $order->getMobile((string)$request->get('mobile'));
            $current_customer['delivery_address'] = $order->getDeliveryAddress((string)$request->get('delivery_address'));
            $current_customer['invoice_address'] = $order->getInvoiceAddress((string)$request->get('invoice_address'));

            $payment = $data['payment'] = $order->getPayment();
            $current_carrier = $data['carrier']['name'] = $order->getCarrier();
            $data['carrier']['cost'] = number_format($order->getCostCarrier(), 3, '.', ' ');
            $data['sub_total'] = $data['total_products'] = number_format($order->getTotalTaxExl(), 3, '.', ' ');
            $data['marge'] = number_format($order->getMarge(), 3, '.', ' ');
            $data['total_discount'] = number_format($order->getDiscount(), 3, '.', ' ');
            $data['total'] = number_format($order->getTotalpaid(), 3, '.', ' ');
            $data['total_tax'] = number_format($order->getTotalTax(), 3, '.', ' ');
            $tax = $order->getTotalTax();
            $data['use_tax'] = 0;
            if ($tax > 0)
                $data['use_tax'] = 1;
            $prods = $em->getRepository('SalesBundle:OrderProducts')->findBy(array('idOrder' => $id_order));

            foreach ($prods as $prod) {
                $id_product = (int)$prod->getIdProduct();
                $p = $em->getRepository('SalesBundle:SalesProduct')->findOneBy(array('id' => $id_product));
                $product = $this->getProduct($p);
                $product['price'] = number_format($prod->getUnitPrice(), 3, '.', ' ');
                $product['quantity'] = $prod->getQuantity();
                $product['total'] = number_format($prod->getTotalProduct(), 3, '.', ' ');
                $data['products'][$id_product] = $product;
            }
        }

        // empty the cart session

        $session->set('cart', $data);

        return $this->render('SalesBundle:orders:add.html.twig', array('title' => 'Ajouter une commande',
            'products' => $products,
            'payments' => $payments,
            'carrier' => $carrier,
            'customer' => $customer,
            'current_customer' => $current_customer,
            'data' => json_encode($data),
            'payment' => $payment,
            'current_carrier' => $current_carrier,
            'tax' => $tax,
        ));
    }

    /**
     * @Route("/admin/sales/orders/invoice/{id}",name="admin_sales_orders_invoice")
     *
     * @Method({"POST","GET"})
     */
    public function invoiceAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $session = new Session();
        $id_order = (int)$request->get('id');

        $data = $current_customer = array();
        $order = $em->getRepository('SalesBundle:SalesOrder')->findOneBy(array('id' => $id_order));

        if ($request->getMethod() == 'POST') {
            $lastinvoice = $em->getRepository('SalesBundle:SalesOrder')->getLastInvoice();
            $lastinvoice++;
            $order->setInvoiceNumber($lastinvoice);
            $order->getDateInvoice(new \DateTime());
            $em->persist($order);
            $em->flush($order);
        }

        $invoice_date = $order->getDateInvoice();
        $invoice_number = $order->getInvoiceNumber();

        $current_customer['id_customer'] = $order->getIdCustomer();
        $current_customer['firstname'] = $order->getFirstname((string)$request->get('firstname'));
        $current_customer['lastname'] = $order->getLastname((string)$request->get('lastname'));
        $current_customer['mobile'] = $order->getMobile((string)$request->get('mobile'));
        $current_customer['delivery_address'] = $order->getDeliveryAddress((string)$request->get('delivery_address'));
        $current_customer['invoice_address'] = $order->getInvoiceAddress((string)$request->get('invoice_address'));

        $data['payment'] = $order->getPayment();
        $data['carrier']['name'] = $order->getCarrier();
        $data['carrier']['cost'] = number_format($order->getCostCarrier(), 3, '.', ' ');
        $data['sub_total'] = number_format($order->getTotalTaxExl(), 3, '.', ' ');
        $data['marge'] = number_format($order->getMarge(), 3, '.', ' ');
        $data['total_discount'] = number_format($order->getDiscount(), 3, '.', ' ');
        $data['total'] = number_format($order->getTotalpaid() + 0.600, 3, '.', ' ');
        $data['total_tax'] = number_format($order->getTotalTax(), 3, '.', ' ');

        $prods = $em->getRepository('SalesBundle:OrderProducts')->findBy(array('idOrder' => $id_order));

        foreach ($prods as $prod) {
            $id_product = (int)$prod->getIdProduct();
            $p = $em->getRepository('SalesBundle:SalesProduct')->findOneBy(array('id' => $id_product));
            $product = $this->getProduct($p);
            $product['price'] = number_format($prod->getUnitPrice(), 3, '.', ' ');
            $product['quantity'] = $prod->getQuantity();
            $product['total'] = number_format($prod->getTotalProduct(), 3, '.', ' ');
            $data['products'][$id_product] = $product;
        }
        $convert = new Nuts($data['total'], "TND");
        $total_lettre = $convert->convert("fr-FR");

        $invoice_number = str_pad($invoice_number, 6, "0", STR_PAD_LEFT);

        $mois = array(1 => 'Janvier',
            2 => 'Février',
            3 => 'Mars',
            4 => 'Avril',
            5 => 'Mai',
            6 => 'Juin',
            7 => 'Juillet',
            8 => 'Aout',
            9 => 'Septembre',
            10 => 'Octobre',
            11 => 'Novembre',
            12 => 'Décembre');

        $session->set('cart', $data);

        return $this->render('SalesBundle:orders:invoice.html.twig', array(
            'current_customer' => $current_customer,
            'data' => $data,
            'invoice_date' => $invoice_date->format('d').' '.$mois[(int)$invoice_date->format('m')].' '.$invoice_date->format('Y'),
            'invoice_number' => $invoice_number,
            'id_order' => $id_order,
            'total_lettre' => $total_lettre,
        ));
    }

    /**
     * @Route("/admin/sales/cart/add_product",name="admin_sales_cart_addproduct")
     *
     * @Method({"POST","GET"})
     */
    public function cartAddProductAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id_product = (int)$request->get('id_product');
        $quantity = (int)$request->get('quantity');

        $session = new Session();
        $data = $session->get('cart');
        if (isset($data['products'][$id_product])) {
            $data['products'][$id_product]['quantity'] += $quantity;
            $data['products'][$id_product]['total'] = $data['products'][$id_product]['price'] * $data['products'][$id_product]['quantity'];
        } else {
            $prod = $em->getRepository('SalesBundle:SalesProduct')->findOneBy(array('id' => $id_product));
            $product = $this->getProduct($prod);
            $product['quantity'] = $quantity;
            $product['total'] = number_format((float)$product['price'] * $quantity, 3, '.', ' ');
            $data['products'][$id_product] = $product;
        }
        $data['payment'] = '';

        if (!isset($data['use_tax'])) {
            $data['use_tax'] = 1;
        }

        if (!isset($data['carrier']['cost'])) {
            $data['carrier'] = array('name' => '', 'cost' => number_format(0, 3, '.', ' '));
        }

        $data = $this->getTotales($data);

        $session->set('cart', $data);

        return new JsonResponse($data);
    }

    /**
     * @Route("/admin/sales/cart/manager",name="admin_sales_cart_manager")
     *
     * @Method({"POST","GET"})
     */
    public function manageCartAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $action = (string)$request->get('action');
        $session = new Session();
        $data = $session->get('cart');

        if ($action == 'updateCarrier') {
            $data['carrier']['name'] = (string)$request->get('name');
            $data['carrier']['cost'] = number_format((float)$request->get('cost'), 3, '.', ' ');
            $data = $this->getTotales($data);
        } elseif ($action == 'updatePayment') {
            $data['payment'] = (string)$request->get('payment');
        } elseif ($action == 'updateTax') {
            $data['use_tax'] = (int)$request->get('use_tax');
        }

        $session->set('cart', $data);

        return new JsonResponse($data);
    }

    /**
     * @Route("/admin/sales/cart/delete_product",name="admin_sales_cart_deleteproduct")
     *
     * @Method({"POST","GET"})
     */
    public function cartDeleteProductAction(Request $request)
    {
        $id_product = (int)$request->get('id_product');

        $session = new Session();
        $data = $session->get('cart');

        if ($id_product > 0 && isset($data['products'][$id_product])) {
            unset($data['products'][$id_product]);
        }

        $data = $this->getTotales($data);

        $session->set('cart', $data);

        return new JsonResponse($data);
    }

    private function getProduct($prod)
    {
        $product = array();
        $product['id'] = $prod->getId();
        $product['name'] = $prod->getName();
        $product['promotion'] = $prod->getPromo();
        $product['use_promo'] = $prod->getEnablePromo();
        $price = ($product['use_promo']) ? $prod->getPrice() - ($prod->getPrice() * $product['promotion'] / 100) : $prod->getPrice();
        $product['price'] = number_format($price, 3, '.', ' ');
        $product['tax'] = $prod->getTax();
        $product['use_tax'] = $prod->getUseTax();

        return $product;
    }

    private function getTotales($data)
    {

        $total_product = 0;
        $total_discount = 0;

        foreach ($data['products'] as $key => $product) {
            $total_product += (float)$product['price'] * $product['quantity'];
            $total_discount += ($product['use_promo']) ? ((float)$product['price'] * $product['promotion'] / 100) * $product['quantity'] : 0;
        }

        $marge = ($total_product * 0.01);
        $data['total_products'] = number_format($total_product, 3, '.', ' ');
        $data['total_discount'] = number_format($total_discount, 3, '.', ' ');
        $data['marge'] = number_format($marge, 3, '.', ' ');
        $data['sub_total'] = number_format($total_product, 3, '.', ' ');
        $tax = ($data['use_tax'] == 1) ? (($total_product + $marge) * 0.19) : 0;
        $data['total_tax'] = number_format($tax, 3, '.', ' ');
        $total = ($total_product + $tax + $marge + (float)$data['carrier']['cost']);
        $data['total'] = number_format($total, 3, '.', ' ');

        return $data;
    }

}
