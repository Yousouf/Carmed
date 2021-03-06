<?php

namespace SalesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use SalesBundle\Entity\SalesProduct;
use SalesBundle\Classes\TCPDFClass;

class ProductsController extends Controller
{
    /**
     * @Route("/admin/sales/products",name="admin_sales_products")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('SalesBundle:SalesProduct')->findAll();

        return $this->render('SalesBundle:products:index.html.twig',array('data'=>$products));
    }
	
	 /**
     * @Route("/admin/sales/products/list",name="admin_sales_products_list")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('SalesBundle:SalesProduct')->findAll();

        $pdf = new TCPDFClass('P', 'mm', 'A4', true, 'UTF-8', false, false);
        $pdf->SetAuthor('Admin Caremed');
        $pdf->SetTitle('Liste Produits');
        $pdf->SetAutoPageBreak(true, 30);
        $pdf->SetMargins(5, 40, 5, true);
        $pdf->SetHeaderMargin(50);
        $pdf->SetFooterMargin(30);
        $pdf->AddPage();

        $filename = "product_list_";
        $html = $this->renderView(
            'SalesBundle:products:list.html.twig',array('data'=>$products)
        );

        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);



        $response = new Response($pdf->Output($filename . ".pdf", 'I'));
        $response->headers->set('Content-type', 'application/pdf');

        return $response;
        //return $this->render('SalesBundle:products:list.html.twig',array('data'=>$products));
    }

    /**
     * @Route("/admin/sales/products/add",name="admin_sales_products_add")
     *
     * @Method({"POST","GET"})
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($request->getMethod() == 'POST') {

            $data = $request->get('product');

            $product = new SalesProduct();

            $product->setName((string)$data['name']);
            $product->setDescription((string)$data['description']);
            $product->setShortDescription((string)$data['short_description']);
            $product->setSku((string)$data['sku']);
            $product->setPrice((float)$data['price']);
            $product->setStatus( (isset($data['status'])) ? 1 : 0);
            $product->setTax((float)$data['tax']);
            $product->setUseTax((isset($data['use_tax'])) ? 1 : 0);
            $product->setPromo((float)$data['promotion']);
            $product->setEnablePromo((isset($data['enable_promo'])) ? 1 : 0);
            $product->setDateAdd(new \DateTime());
            $product->setDateUpd(new \DateTime());

            $em->persist($product);
            $em->flush($product);

            if((int)$request->get('save'))
                return $this->redirectToRoute('admin_sales_products');
            elseif((int)$request->get('save_edit'))
                return $this->redirectToRoute('admin_sales_products_update',array('id'=>$product->getId()));
        }

        return $this->render('SalesBundle:products:form.html.twig',array('title'=>"Ajout d'un Produit"));
    }

    /**
     * @Route("/admin/sales/products/update/{id}",name="admin_sales_products_update")
     *
     * @Method({"POST","GET"})
     */
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('SalesBundle:SalesProduct')->findOneBy(array('id'=>(int)$request->get('id')));

        if ($request->getMethod() == 'POST') {

            $data = $request->get('product');

            $product->setName((string)$data['name']);
            $product->setDescription((string)$data['description']);
            $product->setShortDescription((string)$data['short_description']);
            $product->setSku((string)$data['sku']);
            $product->setPrice((float)$data['price']);
            $product->setStatus( (isset($data['status'])) ? 1 : 0);
            $product->setTax((float)$data['tax']);
            $product->setUseTax((isset($data['use_tax'])) ? 1 : 0);
            $product->setPromo((float)$data['promotion']);
            $product->setEnablePromo((isset($data['enable_promo'])) ? 1 : 0);
            $product->setDateUpd(new \DateTime());

            $em->persist($product);
            $em->flush($product);

            if((int)$request->get('save'))
                return $this->redirectToRoute('admin_sales_products');
            elseif((int)$request->get('save_edit'))
                return $this->redirectToRoute('admin_sales_products_update',array('id'=>$product->getId()));
        }

        return $this->render('SalesBundle:products:form.html.twig',array('product'=>$product, 'title'=>"Mise à jour Produit"));
    }

    /**
     * @Route("/admin/sales/products/delete/{id}",name="admin_sales_products_delete")
     *
     * @Method({"POST","GET"})
     */
    public function deleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if((int)$request->get('id') > 0){
            $product = $em->getRepository('SalesBundle:SalesProduct')->findOneBy(array('id'=>(int)$request->get('id')));
            $em->remove($product);
            $em->flush($product);
            $em->clear();
        }

        return $this->redirectToRoute('admin_sales_products');
    }
}
