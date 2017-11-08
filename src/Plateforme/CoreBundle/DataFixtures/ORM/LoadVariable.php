<?php
// src/Plateforme/CoreBundle/DataFixtures/ORM/LoadCivilite.php
namespace Plateforme\CoreBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Plateforme\CoreBundle\Entity\Variable;
class LoadVariable extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $variable1 = new Variable();
    $variable1->setCode('site_name');
    $variable1->setLabel('Nom du site');
    $variable1->setValue('Plateforme AD');
    $manager->persist($variable1);
    
    $variable2 = new Variable();
    $variable2->setCode('adresse_voie');
    $variable2->setLabel('Adresse - voie');
    $variable2->setValue('13 rue Alphonse Daudet');
    $manager->persist($variable2);
    
    $variable3 = new Variable();
    $variable3->setCode('adresse_complement');
    $variable3->setLabel("Adresse - Complément d'adresse");
    $variable3->setValue('');
    $manager->persist($variable3);
    
    $variable4 = new Variable();
    $variable4->setCode('adresse_code_postal');
    $variable4->setLabel("Adresse - Code Postal");
    $variable4->setValue('19100');
    $manager->persist($variable4);
    
    $variable5 = new Variable();
    $variable5->setCode('adresse_commune');
    $variable5->setLabel("Adresse - Commune");
    $variable5->setValue('Brive la Gaillarde');
    $manager->persist($variable5);
    
    $variable6 = new Variable();
    $variable6->setCode('adresse_pays');
    $variable6->setLabel("Adresse - Pays (Norme ISO 3166-1 alpha-2)");
    $variable6->setValue('FR');
    $manager->persist($variable6);
    
    $manager->flush();
    $this->addReference('site_name', $variable1);
    $this->addReference('adresse_voie', $variable2);
    $this->addReference('adresse_complement', $variable3);
    $this->addReference('adresse_code_postal', $variable4);
    $this->addReference('adresse_commune', $variable4);
    $this->addReference('adresse_pays', $variable6);
  }
  
  public function getOrder() {
    return 1;  // Order in which this fixture will be executed
  }
}