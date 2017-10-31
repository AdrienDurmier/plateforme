<?php
namespace Plateforme\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Plateforme\CoreBundle\Entity\Sexe;

class LoadSexe extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $sexe1 = new Sexe();
    $sexe1->setSexeName('M');
    $sexe1->setSexeFullname('Homme');
    $manager->persist($sexe1);
    
    $sexe2 = new Sexe();
    $sexe2->setSexeName('F');
    $sexe2->setSexeFullname('Femme');
    $manager->persist($sexe2);
    
    $manager->flush();
    
    $this->addReference('homme', $sexe1);
    $this->addReference('femme', $sexe2);
  }
  
  public function getOrder() {
    return 1;  // Order in which this fixture will be executed
  }
}