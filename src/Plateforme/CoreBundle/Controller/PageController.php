<?php

namespace Plateforme\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageController extends Controller {

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
    if($valeurs_recu['page_is_public']){
      $request->getSession()->getFlashBag()->add('warning', "Page dépubliée.");
    }else{
      $request->getSession()->getFlashBag()->add('success', "Page publiée.");
    }
    return $this->redirect($request->server->get('HTTP_REFERER'));
  }

}
