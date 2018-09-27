<?php

namespace SalesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/admin/sales")
     */
    public function indexAction()
    {
        return $this->render('SalesBundle:Default:index.html.twig');
    }
}
