<?php

namespace FabricationBundle\Repository;

/**
 * FabricationInventaryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FabricationInventaryRepository extends \Doctrine\ORM\EntityRepository
{
    
    public function getTotalEntree($id_product){
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select("SUM(u.quantity) as in")
            ->from('FabricationBundle:StockFabricationMovement', 'u')
            //->leftjoin('AuthBundle:Menu', 'u1',Join::WITH,'u1.id = u.parent')
            ->where("u.movement = 'entree'")
            ->andwhere("u.idProduct = ".$id_product);
        return $query->getQuery()->getOneOrNullResult();
    }
    
    public function getTotalSortie($id_product){
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select("SUM(u.quantity) as out")
            ->from('FabricationBundle:StockFabricationMovement', 'u')
            ->where("u.movement = 'sortie'")
            ->andwhere("u.idProduct = ".$id_product);
        return $query->getQuery()->getOneOrNullResult();
    }

    public function getAll(){
        $table = $this->getEntityManager()->getClassMetadata("FabricationBundle:FabricationInventary")->getTableName();
        $join1 = $this->getEntityManager()->getClassMetadata("FabricationBundle:ProductsFabrication")->getTableName();
        $sql  = "SELECT a.*, IFNULL(b.name, '--') as product FROM $table a";
        $sql .= " LEFT JOIN $join1 b ON b.id = a.id_product";
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}