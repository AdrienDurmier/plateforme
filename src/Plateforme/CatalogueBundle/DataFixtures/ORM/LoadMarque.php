<?php
namespace Plateforme\CatalogueBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Plateforme\CatalogueBundle\Entity\Marque;

class LoadMarque extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    
    $marque1 = new Marque();
    $marque1->setTitre('Lego');
    $marque1->setContenu("<p>Avec <strong>les briques et personnages LEGO<sup>®</sup></strong>, chaque enfant peut <strong>exprimer librement sa créativité</strong> : chaque idée se construit et prend vie autour d'histoires pleines d'humour et d'imagination. <strong>Les produits LEGO<sup>®</sup></strong> proposent <strong>une offre adaptée à chaque âge</strong> et à chaque envie !</p>");
    $marque1->setLogo($this->getReference('logo_lego'));
    $manager->persist($marque1);
    
    $marque2 = new Marque();
    $marque2->setTitre('Smoby');
    $marque2->setContenu("<p>Smoby est une entreprise française de fabrication de jouets pour enfants, implantée à Lavans-lès-Saint-Claude dans le Jura.</p>");
    $marque2->setLogo($this->getReference('logo_smoby'));
    $manager->persist($marque2);
    
    $marque3 = new Marque();
    $marque3->setTitre('Converse');
    $marque3->setContenu("<p>Converse est une entreprise des États-Unis qui fabrique essentiellement des chaussures de sport. Elle appartient au groupe Nike depuis 2003.</p>");
    $marque3->setLogo($this->getReference('logo_converse'));
    $manager->persist($marque3);
    
    $marque4 = new Marque();
    $marque4->setTitre('Adidas');
    $marque4->setContenu("<p>Adidas est une firme allemande fondée en 1949 par Adolf Dassler, spécialisée dans la fabrication d'articles de sport, basée à Herzogenaurach en Bavière.</p>");
    $marque4->setLogo($this->getReference('logo_adidas'));
    $manager->persist($marque4);
    
    $marque5 = new Marque();
    $marque5->setTitre('Nike');
    $marque5->setContenu("<p>Nike est une entreprise américaine créée en 1971. Basée à Beaverton dans l'Oregon, elle est spécialisée dans la fabrication d'articles de sport.</p>");
    $marque5->setLogo($this->getReference('logo_nike'));
    $manager->persist($marque5);
    
    $marque6 = new Marque();
    $marque6->setTitre('Louboutin');
    $marque6->setContenu("<p>Christian Louboutin, né le 7 janvier 1964 à Paris, est un créateur français de chaussures et de sacs à main de luxe.</p>");
    $marque6->setLogo($this->getReference('logo_louboutin'));
    $manager->persist($marque6);
    
    $marque7 = new Marque();
    $marque7->setTitre('Kickers');
    $marque7->setContenu("<p>Kickers est une marque française créée en 1970, qui produisit au début une large gamme de chaussures et plus tard des vêtements.</p>");
    $marque7->setLogo($this->getReference('logo_kickers'));
    $manager->persist($marque7);
    
    $marque8 = new Marque();
    $marque8->setTitre('Pull-in');
    $marque8->setContenu("<p>Marque française créée en 2000 autour d'une philosophie : révolutionner la lingerie grâce à des imprimés audacieux et un savoir faire exclusif !</p>");
    $marque8->setLogo($this->getReference('logo_pullin'));
    $manager->persist($marque8);
    
    $marque9 = new Marque();
    $marque9->setTitre("Levi's");
    $marque9->setContenu("<p>Levi Strauss & Co., aussi connu sous son diminutif commercial Levi's, est une marque de vêtements américaine haut de gamme connue mondialement pour ses blue-jeans, dont le Levi's 501.</p>");
    $marque9->setLogo($this->getReference('logo_levis'));
    $manager->persist($marque9);
    
    $manager->flush();
    
    $this->addReference('marque_1', $marque1);
    $this->addReference('marque_2', $marque2);
    $this->addReference('marque_3', $marque3);
    $this->addReference('marque_4', $marque4);
    $this->addReference('marque_5', $marque5);
    $this->addReference('marque_6', $marque6);
    $this->addReference('marque_7', $marque7);
    $this->addReference('marque_8', $marque8);
    $this->addReference('marque_9', $marque9);
  }
  
  public function getOrder() {
    return 1;
  }
}