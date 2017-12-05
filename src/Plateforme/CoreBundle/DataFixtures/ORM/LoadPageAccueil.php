<?php
namespace Plateforme\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Plateforme\CoreBundle\Entity\PageAccueil;

class LoadPageAccueil extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $page_accueil = new PageAccueil();
    $page_accueil->setTitre('Plateforme');
    $page_accueil->setContenu("Contenu de la page d'accueil");
    $page_accueil->setMetatitle("Bienvenue sur notre plateforme");
    $page_accueil->setMetadescription("Contenu apparaissant dans les résultats des moteurs de recherches.");
    $manager->persist($page_accueil);
    
    $manager->flush();
  }
  
  public function getOrder() {
    return 1;  // Order in which this fixture will be executed
  }
}