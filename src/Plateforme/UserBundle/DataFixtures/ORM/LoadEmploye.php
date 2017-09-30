<?php
// src/Plateforme/CoreBundle/DataFixtures/ORM/LoadSpecialite.php

namespace Plateforme\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Plateforme\UserBundle\Entity\Employe;

class LoadEmploye extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    // Sexe
    $masculin = $manager->getRepository('PlateformeCoreBundle:Sexe')->findOneBySexeName('M');
    $feminin = $manager->getRepository('PlateformeCoreBundle:Sexe')->findOneBySexeName('F');
    // Civilité
    $monsieur = $manager->getRepository('PlateformeCoreBundle:Civilite')->findOneByPrefixName('M');
    $madame = $manager->getRepository('PlateformeCoreBundle:Civilite')->findOneByPrefixName('Mme');
    $mademoiselle = $manager->getRepository('PlateformeCoreBundle:Civilite')->findOneByPrefixName('Mlle');
    $docteur = $manager->getRepository('PlateformeCoreBundle:Civilite')->findOneByPrefixName('Dr');
    
    // Employe
    $employe1 = new Employe();
    $employe1->setNom('Saint-Michel');
    $employe1->setPrenom('Patrick');
    $employe1->setUsername('Patrick Saint-Michel');
    $employe1->setEmail('web5@comevents.fr');
    $employe1->setSexe($masculin);
    $employe1->setCivilite($monsieur);
    $employe1->setPlainPassword('F1XtuR3s');
    $employe1->setEnabled(true);
    $employe1->setRoles(array('ROLE_PAGE', 'ROLE_CATALOGUE', 'ROLE_SAV', 'ROLE_COMMANDE', 'ROLE_COMPTA', 'ROLE_COMMERCIAL'));
    $manager->persist($employe1);
    
    $manager->flush();
  }
  
  public function getOrder() {
    return 2;  // Order in which this fixture will be executed
  }
}