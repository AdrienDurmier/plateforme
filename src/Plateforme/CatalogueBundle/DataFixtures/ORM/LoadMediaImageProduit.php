<?php
namespace Plateforme\CatalogueBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Plateforme\CatalogueBundle\Entity\MediaImageProduit;

class LoadMediaImageProduit extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $img1 = new MediaImageProduit();
    $img1->setUrl('lego_star_wars_75105.jpeg');
    $img1->setAlt("Lego Star Wars 75105 Millennium Falcon");
    $img1->setFilename("lego_star_wars_75105.jpeg");
    $manager->persist($img1);
    
    $img2 = new MediaImageProduit();
    $img2->setUrl('lego_pompier_60110.jpeg');
    $img2->setAlt("La caserne des pompiers");
    $img2->setFilename("lego_pompier_60110.jpeg");
    $manager->persist($img2);
    
    $img3 = new MediaImageProduit();
    $img3->setUrl('smoby_caserne_sam_le_pompier.jpeg');
    $img3->setAlt("La caserne des pompiers Sam le pompier");
    $img3->setFilename("smoby_caserne_sam_le_pompier.jpeg");
    $manager->persist($img3);
    
    $img4 = new MediaImageProduit();
    $img4->setUrl('converse_ox_classic.jpeg');$img4->setFilename("converse_ox_classic.jpeg");
    $img4->setAlt("Converse OX Classic");
    $manager->persist($img4);
    
    $img5 = new MediaImageProduit();
    $img5->setUrl('Converse_Baskets_montantes_Chuck_Taylor_All_Star_Hi_Core.jpg');$img5->setFilename("Converse_Baskets_montantes_Chuck_Taylor_All_Star_Hi_Core.jpg");
    $img5->setAlt("Converse Baskets montantes Chuck Taylor All Star Hi Core");
    $manager->persist($img5);
    
    $img6 = new MediaImageProduit();
    $img6->setUrl('Chuck_Taylor.jpg');$img6->setFilename("Chuck_Taylor.jpg");
    $img6->setAlt("Converse Chuck Taylor");
    $manager->persist($img6);
    
    $img7 = new MediaImageProduit();
    $img7->setUrl('Chaussure_Stan_Smith.jpg');$img7->setFilename("Chaussure_Stan_Smith.jpg");
    $img7->setAlt("Chaussure Stan Smith");
    $manager->persist($img7);
    
    $manager->flush();
    
    $this->addReference('image_1', $img1);
    $this->addReference('image_2', $img2);
    $this->addReference('image_3', $img3);
    $this->addReference('image_4', $img4);
    $this->addReference('image_5', $img5);
    $this->addReference('image_6', $img6);
    $this->addReference('image_7', $img7);
  }
  
  public function getOrder() {
    return 2;  // Order in which this fixture will be executed
  }
}