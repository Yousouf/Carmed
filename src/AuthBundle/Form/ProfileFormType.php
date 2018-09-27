<?php

namespace AuthBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security; // for security
use Symfony\Component\Security\Core\SecurityContext;

class ProfileFormType extends AbstractType {

    protected $security;
    /*
     * @param object $session (from controller)
     */
    public function __construct (SecurityContext $security) {
        $this->security = $security;
    }
    
    public function buildForm (FormBuilderInterface $builder, array $options) {
        $roles = array();
        if($this->security->isGranted('ROLE_SUPER_ADMIN')) :
            $roles = array(
                'ROLE_SUPER_ADMIN' => 'Administrateur',
                'ROLE_MANAGER' => 'Manager',
                'ROLE_ADMIN' => 'Client',
                'ROLE_SIMPLE_USER' => 'Client simple'
            );
        elseif ($this->security->isGranted('ROLE_ADMIN')) :
            $roles = array(
                'ROLE_ADMIN' => 'Client',
                'ROLE_SIMPLE_USER' => 'Client simple'
            );
        elseif($this->security->isGranted('ROLE_MANAGER')) :
            $roles = array(
                'ROLE_MANAGER' => 'Manager',
                'ROLE_ADMIN' => 'Client',
                'ROLE_SIMPLE_USER' => 'Client simple'
            );
        elseif($this->security->isGranted('ROLE_SIMPLE_USER')) :
            $roles = array(
                'ROLE_SIMPLE_USER' => 'Client simple'
            );
        endif;
        
        
        $builder
                ->add('firstname', null, array('label' => 'form.firstname', 'translation_domain' => 'SpMediaBundle'))
                ->add('lastname', null, array('label' => 'form.lastname', 'translation_domain' => 'SpMediaBundle'))
                
                ->remove('current_password', 'password', array(
                    'label' => 'form.current_password',
                    'translation_domain' => 'FOSUserBundle',
                    'mapped' => false,
                    'required' => false,
                ))
                ->add('plainPassword', 'repeated', array(
                    'type' => 'password',
                    'first_name' => 'new_password',
                    'second_name' => 'new_password_confirmation',
                    'required' => false,
                ))
                
                ->add('roles', 'choice', array(
                    'label' => 'Roles',
                    'choices' => $roles,
                    'translation_domain' => 'SpMediaBundle',
                    'required' => true,
                    'multiple' => true,
                    'expanded' => false,
                    'mapped' => true,
                ))
                ->add('envoyer', 'submit')

        ;
    }

    public function getParent () {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix () {
        return 'app_user_profile';
    }

    // For Symfony 2.x
    public function getName () {
        return $this->getBlockPrefix();
    }

}
