<?php
namespace Plateforme\CatalogueBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Plateforme\CatalogueBundle\Entity\Attribut;

class LoadAttribut extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $attr1 = new Attribut();
    $attr1->setValeur('S');
    $attr1->setCategorie($this->getReference('taille'));
    $manager->persist($attr1);
    $attr2 = new Attribut();
    $attr2->setValeur('M');
    $attr2->setCategorie($this->getReference('taille'));
    $manager->persist($attr2);
    $attr3 = new Attribut();
    $attr3->setValeur('L');
    $attr3->setCategorie($this->getReference('taille'));
    $manager->persist($attr3);
    $attr4 = new Attribut();
    $attr4->setValeur('XL');
    $attr4->setCategorie($this->getReference('taille'));
    $manager->persist($attr4);
    
    $attr5 = new Attribut();
    $attr5->setValeur('Blanc');
    $attr5->setCouleur('#ffffff');
    $attr5->setCategorie($this->getReference('couleur'));
    $manager->persist($attr5);
    $attr6 = new Attribut();
    $attr6->setValeur('Noir');
    $attr6->setCouleur('#000000');
    $attr6->setCategorie($this->getReference('couleur'));
    $manager->persist($attr6);
    $attr7 = new Attribut();
    $attr7->setValeur('Bleu');
    $attr7->setCouleur('#000088');
    $attr7->setCategorie($this->getReference('couleur'));
    $manager->persist($attr7);
    $attr8 = new Attribut();
    $attr8->setValeur('Rouge');
    $attr8->setCouleur('#880000');
    $attr8->setCategorie($this->getReference('couleur'));
    $manager->persist($attr8);
    $attr9 = new Attribut();
    $attr9->setValeur('Vert');
    $attr9->setCouleur('#008800');
    $attr9->setCategorie($this->getReference('couleur'));
    $manager->persist($attr9);
    
    $attr10 = new Attribut();
    $attr10->setValeur('Neuf');
    $attr10->setCategorie($this->getReference('etat'));
    $manager->persist($attr10);
    $attr11 = new Attribut();
    $attr11->setValeur('Occasion');
    $attr11->setCategorie($this->getReference('etat'));
    $manager->persist($attr11);
    
    $manager->flush();
    
  }
  
  public function getOrder() {
    return 2;
  }
}