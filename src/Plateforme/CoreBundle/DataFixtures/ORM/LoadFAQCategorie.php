<?php
namespace Plateforme\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Plateforme\CoreBundle\Entity\FAQCategorie;

class LoadFAQCategorie extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    // Categorie 1
    $faq_categorie = new FAQCategorie();
    $faq_categorie->setCle('technique');
    $faq_categorie->setLabel("Technique");
    $manager->persist($faq_categorie);
    
    // Categorie 2
    $faq_categorie2 = new FAQCategorie();
    $faq_categorie2->setCle('vitres_tactiles');
    $faq_categorie2->setLabel("Vitres tactiles");
    $manager->persist($faq_categorie2);
    
    // Categorie 3
    $faq_categorie3 = new FAQCategorie();
    $faq_categorie3->setCle('livraison_et_suivi');
    $faq_categorie3->setLabel("Livraison et suivi");
    $manager->persist($faq_categorie3);
    
    // Categorie 4
    $faq_categorie4 = new FAQCategorie();
    $faq_categorie4->setCle('remboursements_et_avoirs');
    $faq_categorie4->setLabel("Remboursements et avoirs");
    $manager->persist($faq_categorie4);
    
    $manager->flush();
  }
  
  public function getOrder() {
    return 1;  // Order in which this fixture will be executed
  }
}