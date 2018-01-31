<?php

namespace Plateforme\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Plateforme\CoreBundle\Entity\Contribution;
use Symfony\Component\HttpFoundation\JsonResponse;

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
   * Ajoute un commentaire à une version
   */
  public function addVersionCommentAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $valeurs_recu = $request->request->all();
    $page = $em->getRepository('PlateformeCoreBundle:Page')->find($valeurs_recu['version_id']);
    if (null === $page) {
      throw new NotFoundHttpException("La page ayant l'identifiant " . $valeurs_recu['version_id'] . " n'existe pas.");
    }
    $contribution = new Contribution();
    $contribution->setPage($page);
    $contribution->setUser($this->getUser());
    $contribution->setComment($valeurs_recu['version_comment']);
    $em->persist($contribution);
    $em->flush();

    return $this->redirect($request->server->get('HTTP_REFERER'));
  }

  /**
   * Récupère tous les commentaires d'une version
   */
  public function getVersionCommentsAction(Request $request) {
    $status = true;
    $em = $this->getDoctrine()->getManager();
    $valeurs_recu = $request->request->all();
    $page = $em->getRepository('PlateformeCoreBundle:Page')->find($valeurs_recu['version_id']);
    $contributions = $em->getRepository('PlateformeCoreBundle:Contribution')->findByPage($page);
    $resultContributions = [];
    foreach ($contributions as $contribution) {
      $resultContributions[] = array(
        'id' => $contribution->getId(),
        'user' => $contribution->getUser()->getUsername(),
        'comment' => $contribution->getComment(),
        'date' => date_format($contribution->getCreated(),"d/m/Y \à H:i:s"),
      );
    }
    // S'il n'y a eu aucun résultat
    if (empty($resultContributions)) {
      $status = false;
    }
    $response = array(
      'success' => $status,
      'data' => array(
        'contributions' => $resultContributions
      )
    );
    return new JsonResponse($response);
  }

}
