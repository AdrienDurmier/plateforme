<?php

namespace Plateforme\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Plateforme\CoreBundle\Entity\ReseauxSociaux;
use Plateforme\CoreBundle\Form\ReseauxSociauxType;

class ReseauxSociauxController extends Controller {

  public function indexAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $existant = $em->getRepository('PlateformeCoreBundle:ReseauxSociaux')->findAll();
    $reseaux_sociaux = null;
    if ($existant) {
      $reseaux_sociaux = $existant[0];
    }
    
    return $this->render('PlateformeCoreBundle:ReseauxSociaux:index.html.twig', array(
          'reseaux_sociaux' => $reseaux_sociaux,
    ));
  }

  /**
   * Gestion des réseaux sociaux (liens externes)
   */
  public function manageAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $existant = $em->getRepository('PlateformeCoreBundle:ReseauxSociaux')->findAll();
    if ($existant) {
      $reseaux_sociaux = $existant[0];
    }
    else {
      $reseaux_sociaux = new ReseauxSociaux();
    }
    $form = $this->get('form.factory')->create(ReseauxSociauxType::class, $reseaux_sociaux);

    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($reseaux_sociaux);
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', "Liens vers vos réseaux sociaux modifiés avec succès");
        return $this->redirectToRoute('plateforme_core_reseaux_sociaux');
      }
    }

    return $this->render('PlateformeCoreBundle:ReseauxSociaux:manage.html.twig', array(
          'reseaux_sociaux' => $reseaux_sociaux,
          'form' => $form->createView(),
    ));
  }

}
