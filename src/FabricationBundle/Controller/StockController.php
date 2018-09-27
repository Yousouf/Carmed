<?php

namespace FabricationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FabricationBundle\Entity\StockFabricationMovement;
use FabricationBundle\Entity\FabricationInventary;

class StockController extends Controller {

    /**
     * @Route("/admin/fabrication/stock",name="admin_fabrication_stock")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $stock = $em->getRepository('FabricationBundle:StockFabricationMovement')->getAll();

        return $this->render('FabricationBundle:stock:index.html.twig', array('data' => $stock));
    }

    /**
     * @Route("/admin/fabrication/stock/add",name="admin_fabrication_stock_add")
     * 
     * @Method({"GET", "POST"})
     */
    public function addAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $fournisseurs = $em->getRepository('FabricationBundle:Fournisseur')->findAll();
        $products = $em->getRepository('FabricationBundle:ProductsFabrication')->findAll();

        if ($request->getMethod() == 'POST') {
            $stock = new StockFabricationMovement();
            $id_product = (int) $request->get('id_product');
            $stock->setIdProduct($id_product);
            $stock->setIdUser((int) $this->getUser()->getId());
            $stock->setIdFournisseur((int) $request->get('fournisseur'));
            $stock->setQuantity((int) $request->get('quantity'));
            $stock->setMovement((string) $request->get('movement'));
            $stock->setDateAdd(new \DateTime());
            $stock->setDateUpd(new \DateTime());

            $em->persist($stock);
            $em->flush($stock);
            $this->updateInventory($id_product);
            return $this->redirectToRoute('admin_fabrication_stock');
        }
        return $this->render('FabricationBundle:stock:form.html.twig',array('title'=>"Ajout d'un mouvement",'fournisseurs'=>$fournisseurs, 'products'=>$products));
    }

    /**
     * @Route("/admin/fabrication/stock/edit/{id}",name="admin_fabrication_stock_edit")
     * 
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $fournisseurs = $em->getRepository('FabricationBundle:Fournisseur')->findAll();
        $products = $em->getRepository('FabricationBundle:ProductsFabrication')->findAll();
        $stock = $em->getRepository('FabricationBundle:StockFabricationMovement')->findOneBy(array('id' => (int) $request->get('id')));

        if ($request->getMethod() == 'POST' && !empty($stock)) {
            //$stock = new ProductsFabrication();
            $id_product = (int)$request->get('id_product');
            $stock->setIdProduct($id_product);
            $stock->setIdUser((int) $this->getUser()->getId());
            $stock->setIdFournisseur((int) $request->get('fournisseur'));
            $stock->setQuantity((int) $request->get('quantity'));
            $stock->setMovement((string) $request->get('movement'));
            $stock->setDateUpd(new \DateTime());


            $em->persist($stock);
            $em->flush($stock);
            $this->updateInventory($id_product);
            return $this->redirectToRoute('admin_fabrication_stock');
        }
        return $this->render('FabricationBundle:stock:form.html.twig', array('stock' => $stock,"title"=>"Modification d'un mouvement",'fournisseurs'=>$fournisseurs, 'products'=>$products));
    }

    /**
     * @Route("/admin/fabrication/stock/delete/{id}",name="admin_fabrication_stock_delete")
     * 
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        if ((int) $request->get('id') > 0) {
            $stock = $em->getRepository('FabricationBundle:StockFabricationMovement')->findOneBy(array('id' => (int) $request->get('id')));
            $em->remove($stock);
            $em->flush($stock);
            $em->clear();
            return $this->redirectToRoute('admin_fabrication_stock');
        }

        return new JsonResponse(1);
    }

    /**
     * @Route("/admin/fabrication/inventory",name="admin_fabrication_inventory")
     */
    public function inventoryAction() {
        $em = $this->getDoctrine()->getManager();

        $stock = $em->getRepository('FabricationBundle:FabricationInventary')->getAll();

        return $this->render('FabricationBundle:inventory:index.html.twig', array('data' => $stock));
    }

    private function updateInventory($id_product) {

        $em = $this->getDoctrine()->getManager();

        $inventory = $em->getRepository('FabricationBundle:FabricationInventary')->findOneBy(array('idProduct' => $id_product));
    
        if(empty($inventory)){
            $inventory = new FabricationInventary();
            $inventory->setDateAdd(new \DateTime());
        }
        
        $in = $em->getRepository('FabricationBundle:FabricationInventary')->getTotalEntree($id_product);
        if(!isset($in['in'])){
           $in = 0; 
        } else {
            $in = (int)$in['in'];
        }
        
        $out = $em->getRepository('FabricationBundle:FabricationInventary')->getTotalSortie($id_product);
        if(!isset($out['out'])){
           $out = 0; 
        } else {
            $out = (int)$out['out'];
        }
        
        $inventory->setEntree($in);
        $inventory->setSortie($out);
        $inventory->setIdProduct($id_product);
        $inventory->setRest($in-$out);
        $inventory->setDateUpd(new \DateTime());
        $inventory->setName("");
        
        $em->persist($inventory);
        $em->flush($inventory);
        $em->clear();
    }

}
