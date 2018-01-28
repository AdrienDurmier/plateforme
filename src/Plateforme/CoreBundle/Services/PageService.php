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
      $page->setPageParent($page_original);
    }
  }

  public function afficherArborescence($parent, $niveau, $array) {
    $html = "";
    $niveau_precedent = 0;
    if (!$niveau && !$niveau_precedent){
      $html .= "<ul>";
    }
    foreach ($array AS $noeud) {
      if ($parent == $noeud['parent']) {
        if ($niveau_precedent < $niveau)
          $html .= "<ul>";
        $html .= '<a class="btn btn-light btn-sm text-left" href="">';
          $html .= "<b>".$noeud['titre']."</b>";
          $html .= "<small>";
          $html .= "<br>".date_format($noeud['created'], 'd/m/Y H:i:s');
          $html .= '<br><i class="fa fa-user-o" aria-hidden="true"></i> '.$noeud['username'];
          $html .= '<br><br><i class="fa fa-comment-o" aria-hidden="true"></i> todo';
          $html .= "</small>";
        $html .= "</a>";
        $niveau_precedent = $niveau;
        $html .= $this->afficherArborescence($noeud['id'], ($niveau + 1), $array);
      }
    }
    if (($niveau_precedent == $niveau) && ($niveau_precedent != 0))
      $html .= "</ul></li>";
    else if ($niveau_precedent == $niveau)
      $html .= "</ul>";
    else
      $html .= "</li>";
    return $html;
  }

}
