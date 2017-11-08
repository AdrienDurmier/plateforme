<?php
namespace Plateforme\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Plateforme\EcommerceBundle\Entity\TarifLaposteRecommande;

class LoadTarifLaposteRecommande extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $tarif1 = new TarifLaposteRecommande();
    $tarif1->setPays('FR');
    $tarif1->setTarif(7.99);
    $manager->persist($tarif1);
    $tarif2 = new TarifLaposteRecommande();
    $tarif2->setPays('MC');
    $tarif2->setTarif(7.99);
    $manager->persist($tarif2);
    $tarif3 = new TarifLaposteRecommande();
    $tarif3->setPays('AD');
    $tarif3->setTarif(7.99);
    $manager->persist($tarif3);

    $manager->flush();
  }

  public function getOrder() {
    return 1;  // Order in which this fixture will be executed
  }
}
