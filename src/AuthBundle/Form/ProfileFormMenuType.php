<?php

namespace AuthBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\EntityRepository; // for use $er
use Doctrine\ORM\EntityManager; // for use $em

class ProfileFormMenuType extends AbstractType {

    protected $em;
    /*
     * @param object Site (from controller)
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function buildForm (FormBuilderInterface $builder, array $options) {
        
        $data_main = array();
        $data_config = array();
        $config = 'config';
        $user = $options['data']['user'];
        $security =  $options['data']['security'];
        $menu_user = $options['data']['menu_user']; 
        
        if($security->isGranted('ROLE_SUPER_ADMIN')) :
            $roles = array('ROLE_SUPER_ADMIN' => 'Administrateur', 'ROLE_MANAGER' => 'Manager', 'ROLE_ADMIN' => 'Client', 'ROLE_SIMPLE_USER' => 'Client simple');
        elseif ($security->isGranted('ROLE_ADMIN')) :
            $roles = array( 'ROLE_ADMIN' => 'Client', 'ROLE_SIMPLE_USER' => 'Client simple');
        elseif($security->isGranted('ROLE_MANAGER')) :
            $roles = array( 'ROLE_MANAGER' => 'Manager', 'ROLE_ADMIN' => 'Client', 'ROLE_SIMPLE_USER' => 'Client simple');
        elseif($security->isGranted('ROLE_SIMPLE_USER')) :
            $roles = array('ROLE_SIMPLE_USER' => 'Client simple');
        endif;
        
       
        
        $UsersMainMenu = $this->em->getRepository('FrontBundle:MainMenu')->getMainMenuByUser(explode(',', $menu_user->getIdFrontMenu()));
        if (count($UsersMainMenu))
            foreach ($UsersMainMenu as $key => $UserMenu)
                $data_main[] = $UserMenu;

        $UsersConfMenu = $this->em->getRepository('FrontBundle:MainMenu')->getMainMenuByUser(explode(',', $menu_user->getIdFrontConfig()));
        if (count($UsersConfMenu))
            foreach ($UsersConfMenu as $key => $UserConfMenu)
                $data_config[] = $UserConfMenu;
        
        $builder->add("user_name", null, array('label' => "Nom d'utilisateur",  'required' => true, 'data'=>$user->getUsername()))
                ->add('mail', null, array('label' => "Adresse e-mail", 'required' => true, 'data'=>$user->getEmail()))
                ->add('firstname', null, array('label' => 'form.firstname', 'translation_domain' => 'SpMediaBundle', 'required' => true, 'data'=>$user->getFirstname()))
                ->add('lastname', null, array('label' => 'form.lastname', 'translation_domain' => 'SpMediaBundle', 'required' => true, 'data'=>$user->getLastname()))
                ->add('old_password', 'password', array( 'label' => 'form.current_password', 'translation_domain' => 'FOSUserBundle', 'required' => false))
                ->add('plainPassword', 'repeated', array('type' => 'password', 'first_name' => 'new_password', 'second_name' => 'new_password_confirmation', 'required' => false,))
                ->add('roles', 'choice', array('label' => 'Roles', 'choices' => $roles, 'translation_domain' => 'SpMediaBundle', 'required' => true, 'multiple' => true, 'expanded' => false, 'mapped' => true, 'data'=>$user->getRoles()))
                ->add('id_front_menu', 'entity', array(
                'label' => 'Main Menu',
                'translation_domain' => 'SpMediaBundle',
                'class'    => 'FrontBundle:MainMenu',
                'query_builder' => function (EntityRepository $er) use ($config) {
                        $qb = $er->createQueryBuilder('m');
                        $qb->where('m.front_menu_main_cat != :config ')
                        ->setParameter('config', $config);
                        return $qb;
                },
                'choice_label' => 'front_menu_name',
                'multiple' => true,
                'required' => true,
                'data' => $data_main,
                'em' => $this->em,
                'attr'=> array('class' => 'multi-select')
            ))
            ->add('id_front_config', 'entity', array(
                'label' => 'Configuration Menu',
                'translation_domain' => 'SpMediaBundle',
                'class'    => 'FrontBundle:MainMenu',
                'query_builder' => function (EntityRepository $er) use ($config) {
                        $qb = $er->createQueryBuilder('m');
                        $qb->where('m.front_menu_main_cat = :config ')
                        ->setParameter('config', $config);
                        return $qb;
                },
                'choice_label' => 'front_menu_name',
                'multiple' => true,
                'required' => true,
                'data' => $data_config,
                'em' => $this->em,
                'attr'=> array('class' => 'multi-select')
            ))
             ->add('envoyer', 'submit', array(
                    'attr' => array(
                        'class' => 'btn-success icon-save',
                        'style'=>"margin:auto;display:block;padding: 10px 20px;"
                    )
                ));
    }

   

    public function getBlockPrefix () {
        return 'app_user_profile';
    }


}
