<?php
namespace Plateforme\CatalogueBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Plateforme\CoreBundle\Entity\Image;

class LoadProduitImage extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $img1 = new Image();
    $img1->setUrl('jpeg');
    $img1->setAlt("Lego Star Wars 75105 Millennium Falcon");
    $manager->persist($img1);
    
    $img2 = new Image();
    $img2->setUrl('jpeg');
    $img2->setAlt("La caserne des pompiers");
    $manager->persist($img2);
    
    $manager->flush();
    
    $this->addReference('image_1', $img1);
    $this->addReference('image_2', $img2);
  }
  
  public function getOrder() {
    return 2;  // Order in which this fixture will be executed
  }
}