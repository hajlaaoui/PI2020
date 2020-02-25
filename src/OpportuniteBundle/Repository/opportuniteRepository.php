<?php

namespace OpportuniteBundle\Repository;

/**
 * opportuniteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class opportuniteRepository extends \Doctrine\ORM\EntityRepository
{
    public function approuver($id)
    {
        $Query = $this->getEntityManager()->createQuery(
            "update OpportuniteBundle:opportunite O set O.etat=1 where O.id=:id")
            ->setParameter('id',$id);
        return $Query->getResult();
    }
}
