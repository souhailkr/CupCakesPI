<?php
/**
 * Created by PhpStorm.
 * User: SouhaiKr
 * Date: 19/02/2018
 * Time: 10:52
 */

namespace CupCakesBundle\Repository;

use Doctrine\ORM\EntityRepository;


class IngredientRepository extends EntityRepository
{

    public function findIngredientDQL($id){
        $query=$this->getEntityManager()->createQuery("select m from CupCakesBundle:Ingredient m where m.recette=:id")
            ->setParameter ( 'id',$id) ;
        return $query->getResult();
    }

}