<?php

namespace R9\InbizzBundle\Repository;

/**
 * MarqueetatRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MarqueetatRepository extends \Doctrine\ORM\EntityRepository
{
    public function getSelecterQueryBuilder()
      {
        return $this
          ->createQueryBuilder('m')
          ->orderBy('m.ordre', 'DESC')
        ;
      }
    
    public function findFirst()
    {
        $qb = $this
            ->createQueryBuilder('m')
            ->orderBy('m.ordre', 'DESC')
            ->setMaxResults( 1 )
        ;

        return $qb
            ->getQuery()
            ->getSingleResult()
        ;
    }
}
