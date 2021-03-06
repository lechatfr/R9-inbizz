<?php

namespace R9\InbizzBundle\Repository;

use R9\InbizzBundle\Entity\Marque;
use R9\UserBundle\Entity\User;

/**
 * ContactRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContactRepository extends \Doctrine\ORM\EntityRepository
{
    public function getContactlist(Marque $marque, $contacttype, User $user)
      {
        if ($contacttype=='allie') {
            $qb = $this
                ->createQueryBuilder('c')
                ->where('c.typecontact = :contacttype')
                    ->setParameter('contacttype', $contacttype)
                ->andWhere('c.marque = :marque')
                    ->setParameter('marque', $marque)
                 ->andWhere('c.user != :user')
                    ->setParameter('user', $user)
                ->orderBy('c.nom', 'ASC')
            ;
        } else {
            $qb = $this
                ->createQueryBuilder('c')
                ->where('c.typecontact = :contacttype')
                    ->setParameter('contacttype', $contacttype)
                ->andWhere('c.marque = :marque')
                    ->setParameter('marque', $marque)
                ->orderBy('c.nom', 'ASC')
            ;
        }

        return $qb
            ->getQuery()
            ->getResult()
        ;
      }
    
    public function isMarqueAllie(Marque $marque, User $user)
      {
        $qb = $this
                ->createQueryBuilder('c')
                ->where('c.typecontact = :contacttype')
                    ->setParameter('contacttype', 'allie')
                ->andWhere('c.marque = :marque')
                    ->setParameter('marque', $marque)
                 ->andWhere('c.user = :user')
                    ->setParameter('user', $user)
            ;

        return $qb
            ->getQuery()
            ->getOneOrNullResult()
        ;
      }
    
    public function rechercheContact($termList)
      {
        $qb = $this
                ->createQueryBuilder('c')
                ->leftJoin('c.user', 'u', 'WITH', 'c.typecontact = :ctype')
                    ->setParameter('ctype', 'allie')
                ->addSelect('u')
            //    ->addSelect('c.nom+c.prenom AS fn')
                ->where('c.id=0')
                ->orderBy('c.nom', 'ASC')
                ->addOrderBy('c.prenom', 'ASC');
            ;
        
        $i=0;
        foreach ($termList as $value){
            //$i++;
            //$qb->orWhere(
            //        $qb->expr()->like('fn', ':cfn'.$i)
            //    )
            //   ->setParameter('cfn'.$i, $value.'%')
            //    ;
            if ($value!=''){
                $i++;
                $qb->orWhere(
                        $qb->expr()->like('c.nom', ':cnom'.$i)
                    )
                   ->setParameter('cnom'.$i, $value.'%')
                    ;
                $i++;
                $qb->orWhere(
                        $qb->expr()->like('c.prenom', ':cprenom'.$i)
                    )
                   ->setParameter('cprenom'.$i, $value.'%')
                    ;
                $i++;
                $qb->orWhere(
                        $qb->expr()->like('c.projetlist', ':cprojetlist'.$i)
                    )
                   ->setParameter('cprojetlist'.$i, '%'.$value.'%')
                    ;
                $i++;
                $qb->orWhere(
                        $qb->expr()->like('u.connaissancessectorielles', ':uca'.$i)
                    )
                   ->setParameter('uca'.$i, '%'.$value.'%')
                    ;
                $i++;
                $qb->orWhere(
                        $qb->expr()->like('u.competencesmetier', ':ucb'.$i)
                    )
                   ->setParameter('ucb'.$i, '%'.$value.'%')
                    ;
            }
        }

        return $qb
            ->getQuery()
            ->getResult()
        ;
      }
    
    public function autocompleteContact($q)
      {
        $qb = $this->createQueryBuilder('c');
        $qb
//            ->select(array('c.nom','c.prenom','c.projetlist'))
            ->leftJoin('c.user', 'u', 'WITH', 'c.typecontact = :ctype')
                ->setParameter('ctype', 'allie')
//            ->addSelect(array('u.connaissancessectorielles','u.competencesmetier'))
            ->addSelect('u')
            ->where(
                    $qb->expr()->like('c.nom', ':cnom')
                )
               ->setParameter('cnom', $q.'%')
            ->orWhere(
                    $qb->expr()->like('c.prenom', ':cprenom')
                )
               ->setParameter('cprenom', $q.'%')
            ->orWhere(
                    $qb->expr()->like('c.projetlist', ':cprojetlist')
                )
               ->setParameter('cprojetlist', '%'.$q.'%')
            ->orWhere(
                    $qb->expr()->like('u.connaissancessectorielles', ':uconnaissancessectorielles')
                )
               ->setParameter('uconnaissancessectorielles', '%'.$q.'%')
            ->orWhere(
                    $qb->expr()->like('u.competencesmetier', ':ucompetencesmetier')
                )
               ->setParameter('ucompetencesmetier', '%'.$q.'%')
        ;
        
        return $qb
            ->getQuery()
            ->getResult()
        ;
      }
}
