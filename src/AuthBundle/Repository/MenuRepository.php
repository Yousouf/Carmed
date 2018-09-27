<?php

namespace AuthBundle\Repository;


use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Query\Expr\Join;

/**
 * SpMenuRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MenuRepository extends \Doctrine\ORM\EntityRepository
{
    public function getUserMenu($user_menu, $current_root){

        $em = $this->getEntityManager();
        $parameters = array('active'=>true, 'id_parent'=>0,'id'=>$user_menu);
        $qb = $em->createQueryBuilder()
                ->select('(a.id) as id,(a.name) as text, (a.class) as icon, (a.root) as root')
                ->from('AuthBundle:Menu','a')
                ->where('a.id IN (:id)')
                ->andWhere('a.active = :active')
                ->andWhere('a.parent = :id_parent')
                ->orderby('a.sort','ASC');
        $menus = $qb->setParameters($parameters)->getQuery()->getArrayResult();
        foreach($menus as &$menu){
            $parameters['id_parent'] = $menu['id'];
            $children = $qb->setParameters($parameters)->getQuery()->getArrayResult();
            $menu['children'] = "";
            if(!empty($children)){
                $index = array_search($current_root,array_column($children,'root'));
                $menu['current'] = false;
                if($index > -1){
                    $children[$index]['current'] = true;
                    $menu['current'] = true;
                }
                $menu['children'] = $children;
            }else{
                $menu['current'] = false;
                if($menu['root'] === $current_root)
                    $menu['current'] = true;
            }

        }
        return $menus;
    }

    public function getMenus($limit, $page, $desc, $orderBy, $q){

        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select("u.id as id, u.name as name, u.parent as parent,u1.name as parent_name, u.root as root, u.active as active,u.class as class, u.isadmin as isadmin, u.sort as sort")
            ->from('AuthBundle:Menu', 'u')
            ->leftjoin('AuthBundle:Menu', 'u1',Join::WITH,'u1.id = u.parent')
            ->where("u.id > 0");
        $query1 = $this->getEntityManager()
                ->createQueryBuilder()
                ->select("COUNT(u.id) as count")
                ->from('AuthBundle:Menu', 'u')
                ->where("u.id > 0");
        if (!empty($q)) {
            foreach ($q as $key => $val) {
                $query->andwhere("u.$key LIKE '%$val%'");
                $query1->andwhere("u.$key LIKE '%$val%'");
            }
        }

        if ($orderBy != '') :
            $query->orderBy("u.$orderBy", ($desc) ? 'DESC' : 'ASC');
        endif;

        $count = $query1->getQuery()->getOneOrNullResult();

        if($limit == -1){
            $results = $query->getQuery()->getArrayResult();
        }else{
            $paginator = new Paginator($query,false);
            $paginator->getQuery()
                ->setFirstResult($limit * ($page - 1))
                ->setMaxResults($limit);

            $results = $paginator->getIterator()->getArrayCopy();
        }


        return array('data' => $results, 'count' => $count['count']);
    }
}
