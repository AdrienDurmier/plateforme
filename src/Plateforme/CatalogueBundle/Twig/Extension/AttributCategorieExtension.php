<?php

namespace Plateforme\CatalogueBundle\Twig\Extension;

class AttributCategorieExtension extends \Twig_Extension {

  private $em;

  public function __construct(\Doctrine\ORM\EntityManager $entityManager) {
    $this->em = $entityManager;
  }

  public function getFilters() {
    return array(new \Twig_SimpleFilter('getCategoryEntity', array($this, 'getCategoryEntity')));
  }

  function getCategoryEntity($machine) {
    $em = $this->em;
    $categorie = $em->getRepository('PlateformeCatalogueBundle:AttributCategorie')->findOneByMachine($machine);
    return $categorie;
  }

  public function getName() {
    return 'getCategoryEntity';
  }

}
