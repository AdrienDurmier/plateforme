<?php
// src/Plateforme/CoreBundle/DataFixtures/ORM/LoadSpecialite.php

namespace Plateforme\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Plateforme\UserBundle\Entity\Client;

class LoadClient extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $client1 = new Client();
    $client1->setCivilite($this->getReference('monsieur'));
    $client1->setNom('Doe');
    $client1->setPrenom('John');
    $client1->setUsername('John Doe');
    $client1->setTelephone('0669594485');
    $client1->setUsername('John Doe');
    $client1->setEmail('a.durmier.dev@gmail.com');
    $client1->setPlainPassword('john');
    $client1->setEnabled(true);
    $client1->setRoles(array('ROLE_CLIENT'));
    $manager->persist($client1);
    
    $manager->flush();
    
    $this->addReference('client_1', $client1);
    
  }
  
  public function getOrder() {
    return 2;  // Order in which this fixture will be executed
  }
}