<?php
// src/Plateforme/CoreBundle/DataFixtures/ORM/LoadSpecialite.php

namespace Plateforme\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Plateforme\UserBundle\Entity\Employe;

class LoadEmploye extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    // Employe
    $employe1 = new Employe();
    $employe1->setCivilite($this->getReference('monsieur'));
    $employe1->setNom('Durmier');
    $employe1->setPrenom('Adrien');
    $employe1->setUsername('Adrien Durmier');
    $employe1->setEmail('a.durmier@gmail.com');
    $employe1->setPlainPassword('adrien');
    $employe1->setEnabled(true);
    $employe1->setRoles(array('ROLE_ADMIN'));
    $manager->persist($employe1);
    
    $manager->flush();
    
    $this->addReference('admin', $employe1);
    
  }
  
  public function getOrder() {
    return 2;  // Order in which this fixture will be executed
  }
}