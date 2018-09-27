<?php

namespace AuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use UserBundle\Entity\SpMenu;

class MenuController extends Controller
{
    /**
     * @Route(path="/admin/menus", name="admin_menus")
     *
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $limit = $request->get('rowsPerPage');
        $page = $request->get('page');
        $desc = (in_array($request->get('descending'),array('false','')) ) ? 0 : 1;
        $orderBy = $request->get('sortBy');
        $query = $request->get('query');

        $mes = array(array('value'=>0,'text'=>'parent'));

        if($page == 1){
            $m = $em->getRepository('AuthBundle:Menu')->findAll();
            foreach($m as $n){
                array_push($mes,array('value'=>$n->getId(),'text'=>$n->getName()));
            }
        }

        $menus = $em->getRepository('AuthBundle:Menu')->getMenus($limit, $page, $desc, $orderBy, $query);

        return new JsonResponse(array('me'=>$menus,'menus'=>$mes));
    }


    /**
     * @Route(path="/api/add_menu")
     *
     * @Method("POST")
     */
    public function SetMenuAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $response = array();

        if ($request->isMethod('POST')) {

            $id_menu = (int)$request->get('id');
            $name = (string)$request->get('name');
            $parent = (int)$request->get('parent');
            $active = (bool)$request->get('active');
            $root  = (string)$request->get('root');
            $isadmin = (bool)$request->get('isadmin');
            $class = (string)$request->get('class');
            $sort = (int)$request->get('sort');

            if($id_menu > 0) {
                // Edit user
                $menu = $em->getRepository('AuthBundle:Menu')->findOneBy(array('id'=>$id_menu));
            }else{
                // add new user
                $menu = new SpMenu();
            }

            if(!empty($menu)){
                $menu->setName($name);
                $menu->setParent($parent);
                $menu->setRoot($root);
                $menu->setClass($class);
                $menu->setIsadmin($isadmin);
                $menu->setActive($active);
                $menu->setSort($sort);
                $em->persist($menu);
                $em->flush();
                $em->clear();
                $response['status'] = 'success';
                $response['message'] = 'Modification effectuée avec succès.';
            }else{
                $response['status'] = 'error';
                $response['message'] = 'Modification non effectuée.';
            }

        }

        return new JsonResponse($response);
    }
}
