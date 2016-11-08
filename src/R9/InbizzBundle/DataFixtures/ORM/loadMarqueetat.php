<?php

// src/R9/InbizzBundle/DataFixtures/ORM/loadMarqueetat.php


namespace R9\InbizzBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use R9\InbizzBundle\Entity\Marqueetat;

class LoadMarqueetat implements FixtureInterface

{
  public function load(ObjectManager $manager)
  {
    // Liste des noms de compétences à ajouter
    $items = array(
        array(
            'nom' => 'Actif',
            'valeur' => 'actif',
            'ordre' => 1,
        ), 
        array(
            'nom' => 'Non actif',
            'valeur' => 'inactif',
            'ordre' => 3,
        ), 
        array(
            'nom' => 'Inbizz',
            'valeur' => 'inbizz',
            'ordre' => 2,
        ), 
    );
      
    foreach ($items as $item) {
      // On crée la compétence
      $entity = new Marqueetat();
      $entity->setNom($item['nom']);
      $entity->setValeur($item['valeur']);
      $entity->setOrdre($item['ordre']);

      // On la persiste
      $manager->persist($entity);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}