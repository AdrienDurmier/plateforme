<?php

namespace Plateforme\CoreBundle\Services;

use Plateforme\CoreBundle\Entity\Groupe;

class PageService {

  private $em;
  protected $currentUser;
  private $router;

  public function __construct(\Doctrine\ORM\EntityManager $entityManager, $user, $router) {
    $this->em = $entityManager;
    $this->currentUser = $user;
    $this->router = $router;
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
      $groupe->setMetatitle($page_original->getTitre());
      $groupe->setMetaDescription(strip_tags($page_original->getContenu()));
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

  /**
   * Renvoie en html l'arborescence des versions dans le style de github
   * @param type $parent => id de la version originale puis des parents
   * @param type $niveau => niveau de profondeur en cours dans fonction
   * @param type $array => tableau contenant toutes les versions
   * @param type $route_name => nom de la route de ce type de contenu
   * @return string
   */
  public function afficherArborescence($parent, $niveau, $array, $route_name) {
    $html = "";
    $niveau_precedent = 0;
    if (!$niveau && !$niveau_precedent) {
      $html .= "<ul>";
    }
    foreach ($array AS $noeud) {
      if ($parent == $noeud['parent']) {
        if ($niveau_precedent < $niveau) {
          $html .= "<ul>";
        }
        $url = $this->router->generate($route_name, array('id' => $noeud['id']));
        $html .= "<li>";
        $html .= '<span class="btn-group m-1" role="group" aria-label="First group">';
          $html .= '<a class="btn btn-light btn-sm text-left border" href="' . $url . '">';
          $html .= "<small>";
            $html .= '<b>' . $noeud['commentaireVersion'] . '</b>';
            $html .= '<br>par ' . $noeud['username'];
            $html .= '<br>le ' . date_format($noeud['created'], 'd/m/Y H:i:s');
          $html .= "</small>";
          $html .= "</a>";
          $html .= '<a class="btn btn-primary add_comment_link" href="#" data-version-id="' . $noeud['id'] . '" data-toggle="modal" data-target="#versionCommentModal">';
            $html .= '<i class="far fa-comments"></i>';
          $html .= '</a>';
        $html .= "</span>";
        $niveau_precedent = $niveau;
        $html .= $this->afficherArborescence($noeud['id'], ($niveau + 1), $array, $route_name);
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
