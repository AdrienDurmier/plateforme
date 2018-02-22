<?php

namespace Plateforme\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Plateforme\CoreBundle\Entity\PageApprobation;
use Plateforme\CoreBundle\Entity\PageCommentaire;
use Symfony\Component\HttpFoundation\JsonResponse;
use Plateforme\CoreBundle\Entity\GroupeContributeur;

class PageController extends Controller {

  /**
   * Gestion du contenu
   */
  public function contenuAction() {
    $em = $this->getDoctrine()->getManager();
    $pages = $em->getRepository('PlateformeCoreBundle:Page')->getAllPages();
    return $this->render('PlateformeCoreBundle:BackOffice:contenu.html.twig', array(
          'pages' => $pages,
    ));
  }

  /**
   * Publie ou dépublie une page
   */
  public function publicationAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $valeurs_recu = $request->request->all();

    $page = $em->getRepository('PlateformeCoreBundle:Page')->find($valeurs_recu['page_id']);
    if (null === $page) {
      throw new NotFoundHttpException("La page ayant l'identifiant " . $valeurs_recu['page_id'] . " n'existe pas.");
    }
    $page->setIsPublic(!$valeurs_recu['page_is_public']);
    $em->persist($page);
    $em->flush();
    if ($valeurs_recu['page_is_public']) {
      $request->getSession()->getFlashBag()->add('warning', "Page dépubliée.");
    }
    else {
      $request->getSession()->getFlashBag()->add('success', "Page publiée.");
    }
    return $this->redirect($request->server->get('HTTP_REFERER'));
  }

  /**
   * Affiche les contributeurs d'une page
   */
  public function showContributeursAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $groupe = $em->getRepository('PlateformeCoreBundle:Groupe')->find($id);
    if (null === $groupe) {
      throw new NotFoundHttpException("Le groupe de page ayant l'identifiant " . $id . " n'existe pas.");
    }
    $groupe_contributeurs = $em->getRepository('PlateformeCoreBundle:GroupeContributeur')->findByGroupe($groupe);

    return $this->render('PlateformeCoreBundle:Page:contributeurs.html.twig', array(
          'groupe_contributeurs' => $groupe_contributeurs,
          'groupe' => $groupe
    ));
  }

  /**
   * Ajoute un contributeur à un groupe de page
   */
  public function addContributeursAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $valeurs_recu = $request->request->all();
    $user = $em->getRepository('PlateformeUserBundle:Employe')->find($valeurs_recu['contributeur_choice']);
    $groupe = $em->getRepository('PlateformeCoreBundle:Groupe')->find($valeurs_recu['contributeur_groupe']);
    $groupe_contributeur = new GroupeContributeur();
    $groupe_contributeur->setGroupe($groupe);
    $groupe_contributeur->setContributeur($user);
    if (isset($valeurs_recu['contributeur_redacteur'])) {
      $groupe_contributeur->setRedacteur(1);
    }
    if (isset($valeurs_recu['contributeur_verificateur'])) {
      $groupe_contributeur->setVerificateur(1);
    }
    if (isset($valeurs_recu['contributeur_approbateur'])) {
      $groupe_contributeur->setApprobateur(1);
    }
    $em->persist($groupe_contributeur);
    $em->flush();
    $request->getSession()->getFlashBag()->add('success', "Contributeur ajouté avec succès.");
    return $this->redirect($request->server->get('HTTP_REFERER'));
  }

  /**
   * Supprime un contributeur à un groupe de page
   */
  public function deleteContributeursAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $contributeur = $em->getRepository('PlateformeCoreBundle:GroupeContributeur')->find($id);
    $em->remove($contributeur);
    $em->flush();
    $request->getSession()->getFlashBag()->add('success', "Contributeur retiré avec succès");
    return $this->redirect($request->server->get('HTTP_REFERER'));
  }

  /**
   * Recherche de contributeurs en json
   */
  public function searchContributeursAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $query = $request->query->get('term');
    $limit = $request->query->get('limit');
    if (!isset($query)) {
      die("Veuillez saisir un terme");
    }
    $status = true;
    $users = $em->getRepository('PlateformeUserBundle:Employe')->findLikeTerm($query, $limit);
    $resultUsers = [];
    foreach ($users as $user) {
      $resultUsers[] = array(
        'id' => $user['id'],
        'nom' => $user['nom'],
        'prenom' => $user['prenom'],
        'email' => $user['email'],
      );
    }
    if (empty($resultUsers)) {
      $status = false;
    }
    $response = array(
      'success' => $status,
      'data' => array(
        'user' => $resultUsers
      )
    );
    return new JsonResponse($response);
  }

  /**
   * Affiche les versions d'une page
   */
  public function showVersionsAction($id, $route, $page, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $page_original = $em->getRepository('PlateformeCoreBundle:Page')->find($id);
    if (null === $page_original) {
      throw new NotFoundHttpException("La page ayant l'identifiant " . $id . " n'existe pas.");
    }
    // Affichage des versions
    $versions = $page_original->getGroupe()->getPages();
    $first_version = $em->getRepository('PlateformeCoreBundle:Page')->getFirstVersion($page_original->getGroupe());
    $versions_groupe = $em->getRepository('PlateformeCoreBundle:Page')->getAllVersions($page_original->getGroupe());
    $service_versionner = $this->container->get('core_page');
    $html_versions = $service_versionner->afficherArborescence($first_version->getId(), 0, $versions_groupe, 'plateforme_core_page_pages_edit');
    $groupe_contributeurs = $em->getRepository('PlateformeCoreBundle:GroupeContributeur')->findByGroupe($page_original->getGroupe());
    $approbations = $em->getRepository('PlateformeCoreBundle:PageApprobation')->findByPage($page);

    return $this->render('PlateformeCoreBundle:Page:versions.html.twig', array(
          'page' => $page,
          'html_versions' => $html_versions,
          'first_version' => $first_version,
          'route' => $route,
          'versions' => $versions,
          'groupe_contributeurs' => $groupe_contributeurs,
          'approbations' => $approbations,
    ));
  }

  /**
   * Ajoute un commentaire à une page
   */
  public function addPageCommentaireAction(Request $request) {
    $status = true;
    $em = $this->getDoctrine()->getManager();
    $valeurs_recu = $request->request->all();
    $page = $em->getRepository('PlateformeCoreBundle:Page')->find($valeurs_recu['version_id']);
    if (null === $page) {
      throw new NotFoundHttpException("La page ayant l'identifiant " . $valeurs_recu['version_id'] . " n'existe pas.");
    }
    $commentaire = new PageCommentaire();
    $commentaire->setPage($page);
    $commentaire->setUser($this->getUser());
    $commentaire->setComment($valeurs_recu['version_comment']);
    $em->persist($commentaire);
    $em->flush();

    $response = array(
      'success' => $status,
      'data' => array(
        'id' => $commentaire->getId(),
        'user' => $commentaire->getUser()->getUsername(),
        'comment' => $commentaire->getComment(),
        'date' => date_format($commentaire->getCreated(), "d/m/Y \à H:i:s"),
      )
    );
    return new JsonResponse($response);
  }

  /**
   * Mise à jour de l'état d'approbation d'une page
   */
  public function addApprobationAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $valeurs_recu = $request->request->all();
    $user = $this->get('security.token_storage')->getToken()->getUser();
    $approbation = new PageApprobation();
    $page = $em->getRepository('PlateformeCoreBundle:Page')->find($valeurs_recu['approbation_page_id']);
    $approbation->setPage($page);
    $approbation->setContributeur($user);
    $approbation->setEtat($valeurs_recu['approbation_choice']);
    $em->persist($approbation);
    $em->flush();
    $request->getSession()->getFlashBag()->add('success', "Votre approbation a bien été prise en compte.");
    return $this->redirect($request->server->get('HTTP_REFERER'));
  }

  /**
   * Récupère tous les commentaires d'une version
   */
  public function getPageCommentairesAction(Request $request) {
    $status = true;
    $em = $this->getDoctrine()->getManager();
    $valeurs_recu = $request->request->all();
    $page = $em->getRepository('PlateformeCoreBundle:Page')->find($valeurs_recu['version_id']);
    $commentaires = $em->getRepository('PlateformeCoreBundle:PageCommentaire')->findByPage($page);
    $resultPageCommentaires = [];
    foreach ($commentaires as $commentaire) {
      $resultPageCommentaires[] = array(
        'id' => $commentaire->getId(),
        'user' => $commentaire->getUser()->getUsername(),
        'comment' => $commentaire->getComment(),
        'date' => date_format($commentaire->getCreated(), "d/m/Y \à H:i:s"),
      );
    }
    // S'il n'y a eu aucun résultat
    if (empty($resultPageCommentaires)) {
      $status = false;
    }
    $response = array(
      'success' => $status,
      'data' => array(
        'commentaires' => $resultPageCommentaires
      )
    );
    return new JsonResponse($response);
  }

  /**
   * Récupère toutes les contributeurs d'une page
   * FIXME OR REMOVE
   */
  public function getContributeursAction(Request $request) {
    $status = true;
    $em = $this->getDoctrine()->getManager();
    $valeurs_recu = $request->request->all();
    $contributeurs = $em->getRepository('PlateformeCoreBundle:GroupeContributeur')->findByGroupe($valeurs_recu['version_id']);
    $resultPageContributeurs = [];
    foreach ($contributeurs as $contributeur) {
      $resultPageContributeurs[] = array(
        'id' => $contributeur->getId(),
        'nom' => $contributeur->getNom(),
      );
    }
    // S'il n'y a eu aucun résultat
    if (empty($resultPageContributeurs)) {
      $status = false;
    }
    $response = array(
      'success' => $status,
      'data' => array(
        'contributeurs' => $resultPageContributeurs
      )
    );
    return new JsonResponse($response);
  }

}
