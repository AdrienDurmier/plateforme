<?php

namespace Plateforme\CoreBundle\Services;

use Plateforme\CoreBundle\Entity\Groupe;

class PageService {

  private $em;
  protected $currentUser;

  public function __construct(\Doctrine\ORM\EntityManager $entityManager, $user) {
    $this->em = $entityManager;
    $this->currentUser = $user;
  }

  /**
   * Versionning - liaison avec le même groupe de page que la dernière modifiée
   * @params 1: page original ou page nouvelle créée
   * @params 2: nouvelle version à partir de la page originale + ses modifications
   */
  public function versionner($page_original, $page = null) {
    // Création d'un groupe de page afin de préparer le versionning (méthode ADD)
    if ($page == null) {
      $em = $this->em;
      $groupe = new Groupe();
      $groupe->addPage($page_original);
      $em->persist($groupe);
      $page_original->setAuteur($this->currentUser);
    }
    // Ajout d'une version (méthode EDIT)
    else {
      $page_original->getGroupe()->addPage($page);
      $page->setAuteur($this->currentUser);
    }
  }

}
