<?php
/**
 * Created by PhpStorm.
 * User: SouhaiKr
 * Date: 20/02/2018
 * Time: 23:19
 */

namespace CupCakesBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findUserDQL($id){
        $query=$this->getEntityManager()->createQuery("select m from CupCakesBundle:User m where m.recette=:id ")
            ->setParameter ( 'id',$id) ;
        return $query->getResult();
    }


}