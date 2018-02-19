<?php

namespace Plateforme\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Plateforme\CoreBundle\Entity\Contribution;
use Symfony\Component\HttpFoundation\JsonResponse;

class SEOController extends Controller {

  /**
   * Formulaire lors de l'ajout d'une entité
   */
  public function addAction(Request $request) {
    return $this->render('PlateformeCoreBundle:SEO:add.html.twig');
  }

  /**
   * Formulaire lors de l'édition d'une entité
   */
  public function editAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $page_original = $em->getRepository('PlateformeCoreBundle:Page')->find($id);
    if (null === $page_original) {
      throw new NotFoundHttpException("La page ayant l'identifiant " . $id . " n'existe pas.");
    }
    return $this->render('PlateformeCoreBundle:SEO:edit.html.twig', array(
          'page' => $page_original,
    ));
  }

}
