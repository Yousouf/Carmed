<?php

namespace AuthBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType; // for hidden input
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; // for choices input (select list)
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // for entity input

use Doctrine\ORM\EntityRepository; // for use $er
use Doctrine\ORM\EntityManager; // for use $em

use Sp\AuthBundle\Entity\UserMenu;

class UserMenuType extends AbstractType
{
    protected $em;
    /*
     * @param object Site (from controller)
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $em = $this->em;
        $menu_user = $options['data'];

        $data_main = array();
        $data_config = array();
        $config = 'config';

        $UsersMainMenu = $em->getRepository('FrontBundle:MainMenu')->getMainMenuByUser(explode(',', $menu_user->getIdFrontMenu()));
        if (count($UsersMainMenu))
            foreach ($UsersMainMenu as $key => $UserMenu)
                $data_main[] = $UserMenu;

        $UsersConfMenu = $em->getRepository('FrontBundle:MainMenu')->getMainMenuByUser(explode(',', $menu_user->getIdFrontConfig()));
        if (count($UsersConfMenu))
            foreach ($UsersConfMenu as $key => $UserConfMenu)
                $data_config[] = $UserConfMenu;

        $builder
            ->add('id_user', 'entity', array(
                    'label_attr' => array('class' => 'hidden'),//hide label
                    'class' => 'AuthBundle:User',
                    'query_builder' => function (EntityRepository $er) use ($menu_user) {
                        return $er->createQueryBuilder('u')->where('u.id = :id')->setParameter('id', (int)$menu_user->getIdUser()->getId());
                    },
                    'required' => true,
                    'multiple' => false,
                    'property' => 'id',
                    'em' => $em,
                    'attr'=> array('class' => 'hidden')// hide select
                ))
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
                'em' => $em,
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
                'em' => $em,
                'attr'=> array('class' => 'multi-select')
            ))
            ->add('envoyer', 'submit');
    }
    

}
