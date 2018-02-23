<?php
/**
 * Created by PhpStorm.
 * User: SouhaiKr
 * Date: 18/02/2018
 * Time: 17:22
 */

namespace CupCakesBundle\Repository;


use Doctrine\ORM\EntityRepository;

class EtapeRepository extends EntityRepository
{
    public function findEtapeDQL($id){
        $query=$this->getEntityManager()->createQuery("select m from CupCakesBundle:Etape m where m.recette=:id")
            ->setParameter ( 'id',$id) ;
        return $query->getResult();
    }
}