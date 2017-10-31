<?php
// src/Plateforme/CoreBundle/DataFixtures/ORM/LoadCivilite.php

namespace Plateforme\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Plateforme\CoreBundle\Entity\Civilite;

class LoadCivilite extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $civilite1 = new Civilite();
    $civilite1->setPrefixName('M');
    $civilite1->setPrefixFullname('Monsieur');
    $manager->persist($civilite1);
    
    $civilite2 = new Civilite();
    $civilite2->setPrefixName('Mme');
    $civilite2->setPrefixFullname('Madame');
    $manager->persist($civilite2);
    
    $civilite3 = new Civilite();
    $civilite3->setPrefixName('Mlle');
    $civilite3->setPrefixFullname('Mademoiselle');
    $manager->persist($civilite3);
    
    $manager->flush();
    
    $this->addReference('monsieur', $civilite1);
    $this->addReference('madame', $civilite2);
    $this->addReference('mademoiselle', $civilite3);
  }
  
  public function getOrder() {
    return 1;  // Order in which this fixture will be executed
  }
}