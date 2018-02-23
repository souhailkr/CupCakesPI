<?php
/**
 * Created by PhpStorm.
 * User: SouhaiKr
 * Date: 20/02/2018
 * Time: 18:41
 */

namespace CupCakesBundle\Repository;
use Doctrine\ORM\EntityRepository;


class RecetteRepository extends EntityRepository
{
    public function findRecetteDQL($nom){
        $query=$this->getEntityManager()->createQuery("select m from CupCakesBundle:Recette m where m.nom=:nom ")
            ->setParameter ( 'nom',$nom) ;
        return $query->getResult();
    }

}