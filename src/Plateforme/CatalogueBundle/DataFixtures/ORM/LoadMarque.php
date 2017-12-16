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
    $manager->persist($marque1);
    
    $marque2 = new Marque();
    $marque2->setTitre('Smoby');
    $marque2->setContenu("<p>Smoby est une entreprise française de fabrication de jouets pour enfants, implantée à Lavans-lès-Saint-Claude dans le Jura.</p>");
    $manager->persist($marque2);
    
    $marque3 = new Marque();
    $marque3->setTitre('Converse');
    $marque3->setContenu("<p>Converse est une entreprise des États-Unis qui fabrique essentiellement des chaussures de sport. Elle appartient au groupe Nike depuis 2003.</p>");
    $manager->persist($marque3);
    
    $manager->flush();
    
    $this->addReference('marque_1', $marque1);
    $this->addReference('marque_2', $marque2);
    $this->addReference('marque_3', $marque3);
  }
  
  public function getOrder() {
    return 1;
  }
}