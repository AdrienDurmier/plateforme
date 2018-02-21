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
    
    $employe2 = new Employe();
    $employe2->setCivilite($this->getReference('monsieur'));
    $employe2->setNom('Durmier');
    $employe2->setPrenom('Achille');
    $employe2->setUsername('Achille Durmier');
    $employe2->setEmail('achille.durmier@gmail.com');
    $employe2->setPlainPassword('achille');
    $employe2->setEnabled(true);
    $employe2->setRoles(array('ROLE_ADMIN'));
    $manager->persist($employe2);
    
    $employe3 = new Employe();
    $employe3->setCivilite($this->getReference('madame'));
    $employe3->setNom('Herpelinck');
    $employe3->setPrenom('Kathy');
    $employe3->setUsername('Kathy Herpelinck');
    $employe3->setEmail('k.herpelinck.com');
    $employe3->setPlainPassword('kathy');
    $employe3->setEnabled(true);
    $employe3->setRoles(array('ROLE_ADMIN'));
    $manager->persist($employe3);
    
    $manager->flush();
    
    $this->addReference('admin', $employe1);
    $this->addReference('admin2', $employe2);
    $this->addReference('admin3', $employe3);
    
  }
  
  public function getOrder() {
    return 2;  // Order in which this fixture will be executed
  }
}