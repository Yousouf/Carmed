<?php

namespace SalesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use SalesBundle\Entity\Customer;

class CustomerController extends Controller
{
    /**
     * @Route("/admin/sales/customer",name="admin_sales_customer")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $customers = $em->getRepository('SalesBundle:Customer')->findAll();

        return $this->render('SalesBundle:customer:index.html.twig', array('data' => $customers));
    }

    /**
     * @Route("/admin/sales/customer/add",name="admin_sales_customer_add")
     *
     * @Method({"POST","GET"})
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($request->getMethod() == 'POST') {
            $customer = new Customer();
            $customer->setFirstname((string)$request->get('firstname'));
            $customer->setLastname((string)$request->get('lastname'));
            $customer->setMobile((string)$request->get('mobile'));
            $customer->setEmail((string)$request->get('email'));
            $customer->setCountry((string)$request->get('country'));
            $customer->setCity((string)$request->get('city'));
            $customer->setPostalCode((string)$request->get('postalcode'));
            $customer->setAddress((string)$request->get('address'));
            $customer->setDateAdd(new \DateTime());
            $customer->setDateUpd(new \DateTime());

            $em->persist($customer);
            $em->flush($customer);

            if((int)$request->get('save'))
                return $this->redirectToRoute('admin_sales_customer');
            elseif((int)$request->get('save_edit'))
                return $this->redirectToRoute('admin_sales_customer_update',array('id'=>$customer->getId()));
        }


        return $this->render('SalesBundle:customer:form.html.twig',array('title'=>"Ajout d'un nouveau client"));
    }

    /**
     * @Route("/admin/sales/customer/update/{id}",name="admin_sales_customer_update")
     *
     * @Method({"POST","GET"})
     */
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $customer = $em->getRepository('SalesBundle:Customer')->findOneBy(array('id' => (int)$request->get('id')));

        if ($request->getMethod() == 'POST') {
            $customer->setFirstname((string)$request->get('firstname'));
            $customer->setLastname((string)$request->get('lastname'));
            $customer->setMobile((string)$request->get('mobile'));
            $customer->setEmail((string)$request->get('email'));
            $customer->setCountry((string)$request->get('country'));
            $customer->setCity((string)$request->get('city'));
            $customer->setPostalCode((string)$request->get('postalcode'));
            $customer->setAddress((string)$request->get('address'));
            $customer->setDateUpd(new \DateTime());

            $em->persist($customer);
            $em->flush($customer);

            if((int)$request->get('save'))
                return $this->redirectToRoute('admin_sales_customer');
            elseif((int)$request->get('save_edit'))
                return $this->redirectToRoute('admin_sales_customer_update',array('id'=>$customer->getId()));
        }

        return $this->render('SalesBundle:customer:form.html.twig', array('customer' => $customer,'title'=>"Mise a jour client"));
    }

    /**
     * @Route("/admin/sales/customer/delete/{id}",name="admin_sales_customer_delete")
     *
     * @Method({"POST","GET"})
     */
    public function deleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ((int)$request->get('id') > 0) {
            $customer = $em->getRepository('SalesBundle:Customer')->findOneBy(array('id' => (int)$request->get('id')));
            $em->remove($customer);
            $em->flush($customer);
            $em->clear();
        }

        return $this->redirectToRoute('admin_sales_customer');
    }
}
