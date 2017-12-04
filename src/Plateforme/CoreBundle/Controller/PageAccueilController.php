<?php

namespace Plateforme\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Plateforme\CoreBundle\Form\PageAccueilType;

class PageAccueilController extends Controller {

  /**
   *  Page Accueil
   */
  public function indexAction() {
    $em = $this->getDoctrine()->getManager();
    $page_accueil = $em->getRepository('PlateformeCoreBundle:PageAccueil')->findOneByRepere('accueil');
    if (null === $page_accueil) {
      throw new NotFoundHttpException("La page d'accueil n'existe pas.");
    }
    return $this->render('PlateformeCoreBundle:PageAccueil:index.html.twig', array(
          'page' => $page_accueil,
    ));
  }

  /**
   * Formulaire d'édition de la page d'accueil
   */
  public function editAction(Request $request) {
    $em = $this->getDoctrine()->getManager();

    $page_accueil = $em->getRepository('PlateformeCoreBundle:PageAccueil')->findOneByRepere('accueil');
    if (null === $page_accueil) {
      throw new NotFoundHttpException("La page d'accueil n'existe pas.");
    }

    if ($request->isMethod('POST')) {
      $valeurs_recu = $request->request->all();
      // print '<pre>';print_r($valeurs_recu);print '</pre>';die();
      $page_accueil->setTitre($valeurs_recu['titre']);
      $page_accueil->setContenu($valeurs_recu['contenu']);
      if($valeurs_recu['metatitle'] == null || $valeurs_recu['metatitle'] == ''){
        $page_accueil->setMetatitle($valeurs_recu['titre']);
      }else{
        $page_accueil->setMetatitle($valeurs_recu['metatitle']);
      }
      if($valeurs_recu['metadescription'] == null || $valeurs_recu['metadescription'] == ''){
        $page_accueil->setMetadescription(substr($valeurs_recu['contenu'],0,165));
      }else{
        $page_accueil->setMetadescription($valeurs_recu['metadescription']);
      }
      $em->persist($page_accueil);
      $em->flush();
      $request->getSession()->getFlashBag()->add('success', "Page d'accueil modifiée avec succès");
    }

    return $this->render('PlateformeCoreBundle:PageAccueil:edit.html.twig', array(
          'page' => $page_accueil,
    ));
  }

}
