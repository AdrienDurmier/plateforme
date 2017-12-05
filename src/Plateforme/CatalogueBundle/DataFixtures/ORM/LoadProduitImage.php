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
    $img1->setUrl('lego_star_wars_75105.jpeg');
    $img1->setAlt("Lego Star Wars 75105 Millennium Falcon");
    $img1->setFilename("lego_star_wars_75105.jpeg");
    $manager->persist($img1);
    
    $img2 = new Image();
    $img2->setUrl('lego_pompier_60110.jpeg');
    $img2->setAlt("La caserne des pompiers");
    $img2->setFilename("lego_pompier_60110.jpeg");
    $manager->persist($img2);
    
    $img3 = new Image();
    $img3->setUrl('smoby_caserne_sam_le_pompier.jpeg');
    $img3->setAlt("La caserne des pompiers Sam le pompier");
    $img3->setFilename("smoby_caserne_sam_le_pompier.jpeg");
    $manager->persist($img3);
    
    $manager->flush();
    
    $this->addReference('image_1', $img1);
    $this->addReference('image_2', $img2);
    $this->addReference('image_3', $img3);
  }
  
  public function getOrder() {
    return 2;  // Order in which this fixture will be executed
  }
}