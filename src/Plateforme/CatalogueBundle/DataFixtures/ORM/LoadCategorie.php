<?php
namespace Plateforme\CatalogueBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Plateforme\CatalogueBundle\Entity\Categorie;

class LoadCategorie extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    
    $categorie1 = new Categorie();
    $categorie1->setTitre('Vêtements');
    $categorie1->setContenu("<p>Nos vêtements</p>");
    $manager->persist($categorie1);
    $categorie1b = new Categorie();
    $categorie1b->setTitre('T-shirt');
    $categorie1b->setContenu("<p>Nos T-shirts</p>");
    $categorie1b->setCategorie($categorie1);
    $manager->persist($categorie1b);
    $categorie1c = new Categorie();
    $categorie1c->setTitre('Chemises');
    $categorie1c->setContenu("<p>Nos chemises</p>");
    $categorie1c->setCategorie($categorie1);
    $manager->persist($categorie1c);
    $categorie1d = new Categorie();
    $categorie1d->setTitre('Chaussures');
    $categorie1d->setContenu("<p>Nos chaussures</p>");
    $categorie1d->setCategorie($categorie1);
    $manager->persist($categorie1d);
    $categorie1da = new Categorie();
    $categorie1da->setTitre('Baskets');
    $categorie1da->setContenu("<p>Nos baskets</p>");
    $categorie1da->setCategorie($categorie1d);
    $manager->persist($categorie1da);
    $categorie1db = new Categorie();
    $categorie1db->setTitre('Escarpins');
    $categorie1db->setContenu("<p>Nos escarpins</p>");
    $categorie1db->setCategorie($categorie1d);
    $manager->persist($categorie1db);
    
    $categorie2 = new Categorie();
    $categorie2->setTitre('Jouets');
    $categorie2->setContenu("<p>Nos jouets</p>");
    $manager->persist($categorie2);
    
    $categorie3 = new Categorie();
    $categorie3->setTitre('Vins');
    $categorie3->setContenu("<p>Nos vins</p>");
    $manager->persist($categorie3);
    
    $manager->flush();
    
    $this->addReference('categorie_vetements', $categorie1);
    $this->addReference('categorie_jouets', $categorie1);
    $this->addReference('categorie_vins', $categorie1);
    $this->addReference('categorie_tshirt', $categorie1b);
    $this->addReference('categorie_chemise', $categorie1c);
    $this->addReference('categorie_chaussure', $categorie1d);
    $this->addReference('categorie_basket', $categorie1da);
    $this->addReference('categorie_escarpin', $categorie1db);
  }
  
  public function getOrder() {
    return 1;
  }
}