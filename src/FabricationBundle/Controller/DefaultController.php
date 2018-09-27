<?php

namespace FabricationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use FabricationBundle\Entity\Fournisseur;

class DefaultController extends Controller
{
    /**
     * @Route("/admin/fabrication/fournisseur",name="admin_fabrication_fournisseur")
     */
    public function indexAction()
    {
		$em = $this->getDoctrine()->getManager();
		
		$fournisseurs = $em->getRepository('FabricationBundle:Fournisseur')->findAll();
		
        return $this->render('FabricationBundle:fournisseur:index.html.twig',array('data'=>$fournisseurs));
    }
	
	/**
     * @Route("/admin/fabrication/fournisseur/save",name="admin_fabrication_fournisseur_save")
	 * 
	 * @Method("Post")
     */
    public function saveAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		if((int)$request->get('id') == 0){
			$fournisseur = new Fournisseur();
			$fournisseur->setDateAdd(new \DateTime());
		}else{
			$fournisseur = $em->getRepository('FabricationBundle:Fournisseur')->findOneBy(array('id'=>(int)$request->get('id')));
		}
		
		$fournisseur->setName((string)$request->get('name'));
		$fournisseur->setEmail((string)$request->get('email'));
		$fournisseur->setPhone((string)$request->get('phone'));
		$fournisseur->setFax((string)$request->get('fax'));
		$fournisseur->setAdress((string)$request->get('adress'));
		$fournisseur->setDateUpd(new \DateTime());

		$em->persist($fournisseur);	
		$em->flush($fournisseur);		
		//$em->clear();
		
		return new JsonResponse($fournisseur->getId());
    }
	
	/**
     * @Route("/admin/fabrication/fournisseur/delete",name="admin_fabrication_fournisseur_delete")
	 * 
	 * @Method("Post")
     */
    public function deleteAction()
    {
		$em = $this->getDoctrine()->getManager();
		
		if((int)$request->get('id') > 0){
			$fournisseur = $em->getRepository('FabricationBundle:Fournisseur')->findOneBy(array('id'=>(int)$request->get('id')));
			$em->remove($fournisseur);
			$em->flush($fournisseur);		
			$em->clear();
		}
		
        return new JsonResponse(1);
    }
}
