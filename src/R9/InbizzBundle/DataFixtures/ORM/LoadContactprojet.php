<?php

// src/R9/InbizzBundle/DataFixtures/ORM/LoadContactprojet.php


namespace R9\InbizzBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use R9\InbizzBundle\Entity\Contactprojet;

class LoadContactprojet implements FixtureInterface

{
  public function load(ObjectManager $manager)
  {
    // Liste des noms de compétences à ajouter
    $items = array(
        'Design', 
        'Marketing', 
        'Communication', 
        'Event/RP', 
        'Digital'
    );
      
      
    foreach ($items as $item) {
      // On crée la compétence
      $entity = new Contactprojet();
      $entity->setNom($item);

      // On la persiste
      $manager->persist($entity);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}