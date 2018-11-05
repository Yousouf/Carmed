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
     * @Route("/admin/fabrication/products/add",name="admin_fabrication_products_add")
	 * 
	 * @Method("Post")
     */
    public function addAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		
		if ($request->getMethod() == 'POST') {
			$data = $request->get('data');
			$product = new ProductsFabrication();
			$product->setName((string)$request->get('name'));
			$product->setReference((string)$request->get('reference'));
			$product->setWholesalePrice((float)$request->get('price'));
			$product->setTax((float)$request->get('tax'));
			$product->setType((string)$request->get('type'));
			$product->setUnit((string)$request->get('unit'));
			$product->setEmballage((isset($data['emballage'])) ? 1 : 0);
			$product->setDateAdd(new \DateTime());
			$product->setDateUpd(new \DateTime());

			$em->persist($product);	
			$em->flush($product);

			if((int)$request->get('save'))
                return $this->redirectToRoute('admin_fabrication_products');
            elseif((int)$request->get('save_edit'))
                return $this->redirectToRoute('admin_fabrication_products_update',array('id'=>$product->getId()));			
		}
		
		return $this->render('FabricationBundle:products:form.html.twig',array('title'=>"Ajout d'un Matière première"));
    }
	
	/**
     * @Route("/admin/fabrication/products/update/{id}",name="admin_fabrication_products_update")
	 * 
	 * @Method("Post")
     */
    public function updateAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$product = $em->getRepository('FabricationBundle:ProductsFabrication')->findOneBy(array('id'=>(int)$request->get('id')));
		
		if ($request->getMethod() == 'POST') {
			
			$data = $request->get('data');
			
			$product->setName((string)$request->get('name'));
			$product->setReference((string)$request->get('reference'));
			$product->setWholesalePrice((float)$request->get('price'));
			$product->setTax((float)$request->get('tax'));
			$product->setType((string)$request->get('type'));
			$product->setUnit((string)$request->get('unit'));
			$product->setEmballage((isset($data['emballage'])) ? 1 : 0);
			$product->setDateUpd(new \DateTime());

			$em->persist($product);	
			$em->flush($product);

			if((int)$request->get('save'))
                return $this->redirectToRoute('admin_fabrication_products');
            elseif((int)$request->get('save_edit'))
                return $this->redirectToRoute('admin_fabrication_products_update',array('id'=>$product->getId()));			
		}
		
		return $this->render('FabricationBundle:products:form.html.twig',array('product'=>$product,'title'=>"Mise à jour Matière première"));
    }
	
	/**
     * @Route("/admin/fabrication/products/delete/{id}",name="admin_fabrication_products_delete")
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
		
        return $this->redirectToRoute('admin_fabrication_products');
    }
}
