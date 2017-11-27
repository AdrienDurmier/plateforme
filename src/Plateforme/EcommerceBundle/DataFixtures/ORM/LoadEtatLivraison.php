<?php

namespace Plateforme\CatalogueBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Plateforme\EcommerceBundle\Entity\EtatLivraison;

class LoadEtatLivraison extends AbstractFixture implements OrderedFixtureInterface {

  public function load(ObjectManager $manager) {
    $etat1 = new EtatLivraison();
    $etat1->setLabel('A préparer');
    $etat1->setColor('#ffc107 ');
    $manager->persist($etat1);

    $etat2 = new EtatLivraison();
    $etat2->setLabel('Prêt à être expédié');
    $etat2->setColor('#17a2b8');
    $manager->persist($etat2);

    $etat3 = new EtatLivraison();
    $etat3->setLabel('Pris en charge chez le transporteur');
    $etat3->setColor('#17a2b8');
    $manager->persist($etat3);

    $etat4 = new EtatLivraison();
    $etat4->setLabel('Arrivé au site de distribution');
    $etat4->setColor('#17a2b8');
    $manager->persist($etat4);

    $etat5 = new EtatLivraison();
    $etat5->setLabel('Reçu');
    $etat5->setColor('#28a745');
    $manager->persist($etat5);

    $etat6 = new EtatLivraison();
    $etat6->setLabel("N'a pas pu être distribué");
    $etat6->setColor('#dc3545');
    $manager->persist($etat6);

    $etat7 = new EtatLivraison();
    $etat7->setLabel("Disponible dans nos locaux");
    $etat7->setColor('#28a745');
    $manager->persist($etat7);

    $manager->flush();

    $this->addReference('etat_livraison_a_preparer', $etat1);
    $this->addReference('etat_livraison_pret', $etat2);
    $this->addReference('etat_livraison_transporteur', $etat3);
    $this->addReference('etat_livraison_distribution', $etat4);
    $this->addReference('etat_livraison_recu', $etat5);
    $this->addReference('etat_livraison_erreur', $etat6);
    $this->addReference('etat_livraison_locaux', $etat7);
  }

  public function getOrder() {
    return 1;
  }

}
