<?php

namespace AuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function indexAction()
    {
        return $this->render('AuthBundle::layout.html.twig');
    }

    /**
     * @Route("/admin/menu", name="admin_menu")
     */
    public function menuAction($current_root = "")
    {
        $em = $this->getDoctrine()->getManager();

        $user_menu = explode(",", $this->getUser()->getMenu());

        $menu = "";
        if(!empty($user_menu[0])){
            $menu = $em->getRepository('AuthBundle:Menu')->getUserMenu($user_menu, $current_root);
        }

        return $this->render('AuthBundle:Partial:menu.html.twig',array('current_root'=>$current_root,'menus'=>$menu));
    }

    /**
     * @Route("/admin/current_user", name="admin_current_user")
     */
    public function currentUserAction()
    {
        $user = $this->getUser();
        return $this->render('AuthBundle:Partial:current_user.html.twig',array('username'=>$user->getUsername()));
    }

    /**
     * @Route("/admin/notification", name="admin_notification")
     */
    public function notificationAction()
    {
        return $this->render('AuthBundle:Partial:notification.html.twig');
    }
}
