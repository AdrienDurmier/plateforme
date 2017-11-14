<?php
namespace Plateforme\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Plateforme\CoreBundle\Entity\Adresse;

class LoadAdresse extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $adresse1 = new Adresse();
    $adresse1->setTitre('Ma maison');
    $adresse1->setAdresse('13 rue alphonse daudet');
    $adresse1->setComplement('');
    $adresse1->setCodePostal('19100');
    $adresse1->setCommune('Brive la Gaillarde');
    $adresse1->setPays('FR');
    $adresse1->setClient($this->getReference('client_1'));
    $adresse1->setLivraison(true);
    $adresse1->setFacturation(true);
    $manager->persist($adresse1);
    
    $adresse2 = new Adresse();
    $adresse2->setTitre('Chez maman');
    $adresse2->setAdresse('171 rue deschamps');
    $adresse2->setComplement('');
    $adresse2->setCodePostal('19600');
    $adresse2->setCommune('Saint Pantaléon de Larche');
    $adresse2->setPays('FR');
    $adresse2->setClient($this->getReference('client_1'));
    $adresse2->setLivraison(false);
    $adresse2->setFacturation(true);
    $manager->persist($adresse2);
    
    $adresse3 = new Adresse();
    $adresse3->setTitre('En allemagne');
    $adresse3->setAdresse('Pariser Platz 5');
    $adresse3->setComplement('Ambassade allemande');
    $adresse3->setCodePostal('10117');
    $adresse3->setCommune('Berlin');
    $adresse3->setPays('DE');
    $adresse3->setClient($this->getReference('client_1'));
    $adresse3->setLivraison(true);
    $adresse3->setFacturation(true);
    $manager->persist($adresse3);
    
    $manager->flush();
    
    $this->addReference('adresse_1', $adresse1);
    $this->addReference('adresse_2', $adresse2);
  }
  
  public function getOrder() {
    return 3;  // Order in which this fixture will be executed
  }
}