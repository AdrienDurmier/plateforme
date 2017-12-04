<?php
namespace Plateforme\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Plateforme\CoreBundle\Entity\ReseauxSociaux;

class LoadReseauxSociaux extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $reseaux_sociaux = new ReseauxSociaux();
    $reseaux_sociaux->setFacebook('https://fr-fr.facebook.com/');
    $reseaux_sociaux->setTwitter('https://twitter.com/?lang=fr');
    $reseaux_sociaux->setGoogle('https://plus.google.com/?hl=fr');
    $reseaux_sociaux->setYoutube('https://www.youtube.com/');
    $reseaux_sociaux->setViadeo('http://fr.viadeo.com/fr/');
    $reseaux_sociaux->setLinkedin('https://fr.linkedin.com/');
    $reseaux_sociaux->setPinterest('https://www.pinterest.fr/');
    $reseaux_sociaux->setFlickr('https://www.flickr.com/');
    $reseaux_sociaux->setInstagram('https://www.instagram.com/?hl=fr');
    $reseaux_sociaux->setReddit('https://www.reddit.com/');
    $manager->persist($reseaux_sociaux);
    $manager->flush();
    
    $this->addReference('reseaux_sociaux', $reseaux_sociaux);
  }
  
  public function getOrder() {
    return 3;  // Order in which this fixture will be executed
  }
}