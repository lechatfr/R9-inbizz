<?php

namespace R9\InbizzBundle\Repository;

/**
 * MarquestatutRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MarquestatutRepository extends \Doctrine\ORM\EntityRepository
{
    public function getSelecterQueryBuilder()
      {
        return $this
          ->createQueryBuilder('m')
          ->orderBy('m.nom', 'ASC')
        ;
      }
    
    public function findFirst()
    {
        $qb = $this
            ->createQueryBuilder('m')
            ->orderBy('m.nom', 'ASC')
            ->setMaxResults( 1 )
        ;

        return $qb
            ->getQuery()
            ->getSingleResult()
        ;
    }
}