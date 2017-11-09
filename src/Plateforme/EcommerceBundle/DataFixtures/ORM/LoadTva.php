<?php
namespace Plateforme\CatalogueBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Plateforme\EcommerceBundle\Entity\Tva;

class LoadTva extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    // Aucune TVA
    $tva1 = new Tva();
    $tva1->setMultiplicate('1');
    $tva1->setNom('Aucune TVA');
    $tva1->setValeur('0');
    $manager->persist($tva1);

    // TVA à 20%
    $tva2 = new Tva();
    $tva2->setMultiplicate('1.20');
    $tva2->setNom('TVA 20%');
    $tva2->setValeur('20');
    $manager->persist($tva2);

    $manager->flush();

    $this->addReference('tva1', $tva1);
    $this->addReference('tva2', $tva2);
  }
  
  public function getOrder() {
    return 1;  // Order in which this fixture will be executed
  }
}