<?php

namespace AuthBundle\Controller;

use DataSiteBundle\Entity\Site;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;

class UserController extends Controller
{
    /**
     * @Route("/test")
     */
    public function testAction()
    {
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();

            $userid = $user->getId();
            $sites=$this->getDoctrine()
                ->getRepository(Site::class)->getSitesByUser($userid);
            return $this->json($sites,200,['Content-Type'=> 'application/json']);
        }

        return new Response('bonjour test authentification avec token valide');
    }
    /**
     * @Route(path="/admin/users", name="admin_users")
     *
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        
        $menus = array();
		$em = $this->getDoctrine()->getManager();
		$m = $em->getRepository('AuthBundle:Menu')->findAll();
		foreach($m as $n){
			$text = $n->getName();
			array_push($menus,array('value'=>$n->getId(),'text'=>$text));
		}

        
		return $this->render('AuthBundle:User:index.html.twig', array('menu'=>$menus));
    }

    /**
     * @Route(path="/admin/users/get")
     *
     * @Method("POST")
     */
    public function getUsersAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $limit = $request->get('rowsPerPage');
        $page = $request->get('page');
        $desc = (in_array($request->get('descending'),array('false','')) ) ? 0 : 1;
        $orderBy = $request->get('sortBy');
        $query = $request->get('query');

        $users = $em->getRepository('AuthBundle:User')->getUsers($limit, $page, $desc, $orderBy, $query);
		$users["draw"] = $request->get('draw');
		
        return new JsonResponse($users);
    }

    /**
     * @Route(path="/api/add_user")
     *
     * @Method("POST")
     */
    public function SetUserAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $_em = $this->getDoctrine()->getManager('sites');
        $response = array();
        $Site = array();
        if ($request->isMethod('POST')) {

            $id_user = (int)$request->get('id');
            $username = $request->get('username');
            $firstname = $request->get('username');
            $lastname = $request->get('username');
            $email = $request->get('email');
            $status = (bool)$request->get('status');
            $roles = $request->get('roles');
            $sites = (!empty($request->get('sites'))) ? implode(',',$request->get('sites')) : '';
            $menus = (!empty($request->get('menus'))) ? implode(',',$request->get('menus')) : '';
            $plain_password = $request->get('password');
            $userManager = $this->container->get('fos_user.user_manager');
            if($id_user > 0) {
                // Edit user
                $user = $userManager->findUserBy(array('id'=>$id_user));

                $encoder = $this->container->get('security.password_encoder');
                if (!empty($plain_password) && ($plain_password != '')):
                    $Encodepassword = $encoder->encodePassword($user, $plain_password);
                    $user->setPassword($Encodepassword);
                endif;

                $user->setUsername($username);
                $user->setEmail($email);
                $user->setFirstname($firstname);
                $user->setLastname($lastname);
                $user->setRoles($roles);
                $user->setSites($sites);
                $user->setMenu($menus);
                $user->setEnabled($status);

                $userManager = $this->container->get('fos_user.user_manager');
                $userManager->updateUser($user, true);
                $response['status'] = 'success';
                $response['message'] = 'Modification effectuée avec succès.';
            }else{
                // add new user


                $u1 = $userManager->findUserByUsername($username);
                $u2 = $userManager->findUserByEmail($username);
                if(!empty($u1) ||!empty($u2)){
                    $response['status'] = 'error';
                    $response['message'] = 'Compte Existe déja.';
                }else{
                    $user = new User();
                    $encoder = $this->container->get('security.password_encoder');
                    if (!empty($plain_password) && ($plain_password != '')):
                        $Encodepassword = $encoder->encodePassword($user, $plain_password);
                        $user->setPassword($Encodepassword);
                        $user->setUsername($username);
                        $user->setEmail($email);
                        $user->setFirstname($firstname);
                        $user->setLastname($lastname);
                        $user->setRoles($roles);
                        $user->setSites($sites);
                        $user->setMenu($menus);
                        $user->setEnabled($status);

                        $userManager->updateUser($user, true);
                        $response['status'] = 'success';
                        $response['message'] = 'Ajout effectuée avec succès.';
                    else:
                        $response['status'] = 'error';
                        $response['message'] = 'Mot de passe vide';
                    endif;

                }

            }
        }

        return new JsonResponse($response);
    }

}
