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
    
    $civilite4 = new Civilite();
    $civilite4->setPrefixName('Dr');
    $civilite4->setPrefixFullname('Docteur');
    $manager->persist($civilite4);
    
    $civilite5 = new Civilite();
    $civilite5->setPrefixName('Me');
    $civilite5->setPrefixFullname('Maître');
    $manager->persist($civilite5);
    
    $civilite6 = new Civilite();
    $civilite6->setPrefixName('Prs');
    $civilite6->setPrefixFullname('Professeur');
    $manager->persist($civilite6);
    
    $manager->flush();
  }
  
  public function getOrder() {
    return 1;  // Order in which this fixture will be executed
  }
}