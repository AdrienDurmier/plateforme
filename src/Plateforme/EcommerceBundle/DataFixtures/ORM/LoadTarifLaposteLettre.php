<?php
namespace Plateforme\CoreBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Plateforme\EcommerceBundle\Entity\TarifLaposteLettre;
class LoadTarifLaposteLettre extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    // Tarif en France
    $tarif1 = new TarifLaposteLettre();
    $tarif1->setPays('FR');
    $tarif1->setTarif(2.00);
    $manager->persist($tarif1);
    $manager->flush();
  }
  public function getOrder() {
    return 1;  // Order in which this fixture will be executed
  }
}