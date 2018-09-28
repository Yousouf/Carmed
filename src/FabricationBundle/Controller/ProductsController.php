<?php

namespace FabricationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use FabricationBundle\Entity\ProductsFabrication;

class ProductsController extends Controller
{
    /**
     * @Route("/admin/fabrication/products",name="admin_fabrication_products")
     */
    public function indexAction()
    {
		$em = $this->getDoctrine()->getManager();
		
		$products = $em->getRepository('FabricationBundle:ProductsFabrication')->findAll();
		
        return $this->render('FabricationBundle:Products:index.html.twig',array('data'=>$products));
    }
	
	/**
     * @Route("/admin/fabrication/products/save",name="admin_fabrication_products_save")
	 * 
	 * @Method("Post")
     */
    public function saveAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		if((int)$request->get('id') == 0){
			$product = new ProductsFabrication();
			$product->setDateAdd(new \DateTime());
		}else{
			$product = $em->getRepository('FabricationBundle:ProductsFabrication')->findOneBy(array('id'=>(int)$request->get('id')));
		}
		
		$product->setName((string)$request->get('name'));
		$product->setReference((string)$request->get('reference'));
		$product->setWholesalePrice((float)$request->get('price'));
		$product->setTax((float)$request->get('tax'));
		$product->setType((string)$request->get('type'));
		$product->setUnit((string)$request->get('unit'));
		$product->setDateUpd(new \DateTime());

		$em->persist($product);	
		$em->flush($product);		
		//$em->clear();
		
		return new JsonResponse($product->getId());
    }
	
	/**
     * @Route("/admin/fabrication/products/delete",name="admin_fabrication_products_delete")
	 * 
	 * @Method("Post")
     */
    public function deleteAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		
		if((int)$request->get('id') > 0){
			$product = $em->getRepository('FabricationBundle:ProductsFabrication')->findOneBy(array('id'=>(int)$request->get('id')));
			$em->remove($product);
			$em->flush($product);		
			$em->clear();
		}
		
        return new JsonResponse(1);
    }
}
