<?php
namespace Plateforme\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Plateforme\CoreBundle\Entity\PageContact;

class LoadPageContact extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $page_contact = new PageContact();
    $page_contact->setTitre('Nous contacter');
    $page_contact->setContenu('todo');
    $manager->persist($page_contact);
    
    $manager->flush();
  }
  
  public function getOrder() {
    return 1;  // Order in which this fixture will be executed
  }
}