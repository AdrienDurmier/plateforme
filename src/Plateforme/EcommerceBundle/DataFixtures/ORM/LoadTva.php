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
    // TVA à 1.75%
    $tva1 = new Tva();
    $tva1->setMultiplicate('0.982');
    $tva1->setNom('TVA 1.75%');
    $tva1->setValeur('1.75');
    $manager->persist($tva1);

    // TVA à 20%
    $tva2 = new Tva();
    $tva2->setMultiplicate('0.833');
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