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
    $type1->setNom('Taille');
    $manager->persist($type1);
    
    $type2 = new AttributCategorie();
    $type2->setNom('Couleur');
    $manager->persist($type2);
    
    $type3 = new AttributCategorie();
    $type3->setNom('État');
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