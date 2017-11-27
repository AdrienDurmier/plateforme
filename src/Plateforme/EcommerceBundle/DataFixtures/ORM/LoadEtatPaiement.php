<?php
namespace Plateforme\CatalogueBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Plateforme\EcommerceBundle\Entity\EtatPaiement;

class LoadEtatPaiement extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $etat1 = new EtatPaiement();
    $etat1->setLabel('En attente');
    $etat1->setColor('#17a2b8');
    $manager->persist($etat1);
    
    $etat2 = new EtatPaiement();
    $etat2->setLabel('Accepté');
    $etat2->setColor('#28a745');
    $manager->persist($etat2);
    
    $etat3 = new EtatPaiement();
    $etat3->setLabel('Erreur de paiement');
    $etat3->setColor('#dc3545');
    $manager->persist($etat3);

    $manager->flush();

    $this->addReference('etat_paiement_attente', $etat1);
    $this->addReference('etat_paiement_accepte', $etat2);
    $this->addReference('etat_paiement_erreur', $etat3);
  }
  
  public function getOrder() {
    return 1;  // Order in which this fixture will be executed
  }
}