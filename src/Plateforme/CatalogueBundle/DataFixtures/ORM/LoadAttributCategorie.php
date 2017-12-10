<?php
namespace Plateforme\CatalogueBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Plateforme\CatalogueBundle\Entity\AttributCategorie;

class LoadAttributCategorie extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    
    $type1 = new AttributCategorie();
    $type1->setMachine('taille');
    $type1->setNom('Taille');
    $type1->setType('select');
    $manager->persist($type1);
    
    $type2 = new AttributCategorie();
    $type2->setMachine('couleur');
    $type2->setNom('Couleur');
    $type2->setType('color');
    $manager->persist($type2);
    
    $type3 = new AttributCategorie();
    $type3->setMachine('etat');
    $type3->setNom('État');
    $type3->setType('radio');
    $manager->persist($type3);
    
    $manager->flush();
    
    $this->addReference('taille', $type1);
    $this->addReference('couleur', $type2);
    $this->addReference('etat', $type3);
  }
  
  public function getOrder() {
    return 1;
  }
}