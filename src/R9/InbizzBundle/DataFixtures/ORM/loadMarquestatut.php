<?php

// src/R9/InbizzBundle/DataFixtures/ORM/loadMarquestatut.php


namespace R9\InbizzBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use R9\InbizzBundle\Entity\Marquestatut;

class LoadMarquestatut implements FixtureInterface

{
  public function load(ObjectManager $manager)
  {
    // Liste des noms de compétences à ajouter
    $items = array(
        array(
            'nom' => 'SA',
            'ordre' => 1,
        ), 
        array(
            'nom' => 'SARL',
            'ordre' => 2,
        ), 
    );
      
    foreach ($items as $item) {
      // On crée la compétence
      $entity = new Marquestatut();
      $entity->setNom($item['nom']);
      $entity->setOrdre($item['ordre']);

      // On la persiste
      $manager->persist($entity);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}