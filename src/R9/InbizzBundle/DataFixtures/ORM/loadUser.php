<?php

// src/R9/InbizzBundle/DataFixtures/ORM/loadUser.php


namespace R9\InbizzBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use R9\UserBundle\Entity\User;
use FOS\UserBundle\Model\UserInterface;

class LoadUser implements FixtureInterface

{
  public function load(ObjectManager $manager)
  {
    // Liste des noms de compétences à ajouter
    $items = array(
        array(
            'email' => 'mlecoeur@t2bh.fr',
        ), 
        array(
            'email' => 'tbeaumont@t2bh.fr',
        ), 
        array(
            'email' => 'vforce@t2bh.fr',
        ), 
    );
      
      
    global $kernel;
    $userManager = $kernel->getContainer()->get('fos_user.user_manager');
    $encoder = $kernel->getContainer()->get('security.password_encoder');
    
    foreach ($items as $item) {
      
        $user = $userManager->createUser();
        $user->setUsername($item['email']);
        $user->setEmail($item['email']);
        $user->setEmailCanonical($item['email']);
        $user->setLocked(0);
        $user->setEnabled(1);
        $user->setPlainPassword($encoder->encodePassword($user, md5(uniqid())));
        $userManager->updateUser($user);
    }
    
  }
}