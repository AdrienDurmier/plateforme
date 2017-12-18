<?php
namespace Plateforme\CatalogueBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Plateforme\CatalogueBundle\Entity\MediaLogoMarque;

class LoadMediaLogoMarque extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $logo1 = new MediaLogoMarque();
    $logo1->setUrl('converse.jpeg');
    $logo1->setAlt("Converse");
    $logo1->setFilename("converse.jpeg");
    $manager->persist($logo1);
    
    $logo2 = new MediaLogoMarque();
    $logo2->setUrl('lego.jpeg');
    $logo2->setAlt("Lego");
    $logo2->setFilename("lego.jpeg");
    $manager->persist($logo2);
    
    $logo3 = new MediaLogoMarque();
    $logo3->setUrl('smoby.jpeg');
    $logo3->setAlt("Smoby");
    $logo3->setFilename("smoby.jpeg");
    $manager->persist($logo3);
    
    $logo4 = new MediaLogoMarque();
    $logo4->setUrl('adidas.jpeg');
    $logo4->setAlt("Adidas");
    $logo4->setFilename("adidas.jpeg");
    $manager->persist($logo4);
    
    $logo5 = new MediaLogoMarque();
    $logo5->setUrl('nike.jpeg');
    $logo5->setAlt("Nike");
    $logo5->setFilename("nike.jpeg");
    $manager->persist($logo5);
    
    $logo6 = new MediaLogoMarque();
    $logo6->setUrl('louboutin.jpeg');
    $logo6->setAlt("Louboutin");
    $logo6->setFilename("louboutin.jpeg");
    $manager->persist($logo6);
    
    $logo7 = new MediaLogoMarque();
    $logo7->setUrl('kickers.jpeg');
    $logo7->setAlt("Kickers");
    $logo7->setFilename("kickers.jpeg");
    $manager->persist($logo7);
    
    $logo8 = new MediaLogoMarque();
    $logo8->setUrl('pullin.jpeg');
    $logo8->setAlt("Pull-in");
    $logo8->setFilename("pullin.jpeg");
    $manager->persist($logo8);
    
    $logo9 = new MediaLogoMarque();
    $logo9->setUrl('levis.jpeg');
    $logo9->setAlt("Levi's");
    $logo9->setFilename("levis.jpeg");
    $manager->persist($logo9);
    
    $manager->flush();
    
    $this->addReference('logo_converse', $logo1);
    $this->addReference('logo_lego', $logo2);
    $this->addReference('logo_smoby', $logo3);
    $this->addReference('logo_adidas', $logo4);
    $this->addReference('logo_nike', $logo5);
    $this->addReference('logo_louboutin', $logo6);
    $this->addReference('logo_kickers', $logo7);
    $this->addReference('logo_pullin', $logo8);
    $this->addReference('logo_levis', $logo9);
  }
  
  public function getOrder() {
    return 1;  // Order in which this fixture will be executed
  }
}