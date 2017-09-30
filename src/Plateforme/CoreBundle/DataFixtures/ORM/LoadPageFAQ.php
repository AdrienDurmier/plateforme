<?php
namespace Plateforme\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Plateforme\CoreBundle\Entity\PageFAQ;

class LoadPageFAQ extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $page_faq = new PageFAQ();
    $page_faq->setTitre('Foire aux questions');
    $page_faq->setContenu("Lorem ipsum... exemple de texte administrable");
    $manager->persist($page_faq);
    
    $manager->flush();
  }
  
  public function getOrder() {
    return 1;  // Order in which this fixture will be executed
  }
}