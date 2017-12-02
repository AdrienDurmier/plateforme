<?php

namespace Plateforme\CoreBundle\Controller;

use Plateforme\CoreBundle\Entity\PageActualite;
use Plateforme\CoreBundle\Form\PageActualiteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PageActualiteController extends Controller {

  /**
   * Actualites
   */
  public function indexAction() {
    $em = $this->getDoctrine()->getManager();
    $actualites = $em->getRepository('PlateformeCoreBundle:PageActualite')->findAll();
    return $this->render('PlateformeCoreBundle:PageActualite:index.html.twig', array(
          'actualites' => $actualites,
    ));
  }

  /**
   * Gestion des actualités
   */
  public function crudAction() {
    $em = $this->getDoctrine()->getManager();
    $actualites = $em->getRepository('PlateformeCoreBundle:PageActualite')->findAll();
    return $this->render('PlateformeCoreBundle:PageActualite:crud.html.twig', array(
          'actualites' => $actualites,
    ));
  }

  /**
   * Formulaire de création d'une actualite
   */
  public function addAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $actualite = new PageActualite();
    $form = $this->get('form.factory')->create(PageActualiteType::class, $actualite);

    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($actualite);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', "Actualite créée avec succès");
        return $this->redirectToRoute('plateforme_core_page_actualites_view', array('slug' => $actualite->getSlug()));
      }
    }
    return $this->render('PlateformeCoreBundle:PageActualite:add.html.twig', array(
          'form' => $form->createView(),
    ));
  }

  /**
   * Formulaire d'édition d'une actualite
   */
  public function editAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $actualite = $em->getRepository('PlateformeCoreBundle:PageActualite')->find($id);
    if (null === $actualite) {
      throw new NotFoundHttpException("L'actualité ayant l'identifiant " . $id . " n'existe pas.");
    }
    $form = $this->get('form.factory')->create(PageActualiteType::class, $actualite);

    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($actualite);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', "Actualite modifiée avec succès");
        return $this->redirectToRoute('plateforme_core_page_actualites_view', array('slug' => $actualite->getSlug()));
      }
    }

    return $this->render('PlateformeCoreBundle:PageActualite:edit.html.twig', array(
          'actualite' => $actualite,
          'form' => $form->createView(),
    ));
  }

  /**
   * Formulaire pour cloner une actualite
   */
  public function cloneAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $actualite = $em->getRepository('PlateformeCoreBundle:PageActualite')->find($id);
    if (null === $actualite) {
      throw new NotFoundHttpException("L'actualite ayant l'identifiant " . $id . " n'existe pas.");
    }
    $actualite_clone = new PageActualite();
    $actualite_clone->setTitre("[CLONE] " . $actualite->getTitre());
    $actualite_clone->setContenu($actualite->getContenu());
    $em->persist($actualite_clone);
    $em->flush();
    $request->getSession()->getFlashBag()->add('info', "Actualite clonée avec succès");
    return $this->redirectToRoute('plateforme_core_page_actualites_crud');
  }

  /**
   * Formulaire de suppression d'une actualite
   */
  public function deleteAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $actualite = $em->getRepository('PlateformeCoreBundle:PageActualite')->find($id);
    if (null === $actualite) {
      throw new NotFoundHttpException("L'actualité ayant l'identifiant " . $id . " n'existe pas.");
    }
    $em->remove($actualite);
    $em->flush();
    $request->getSession()->getFlashBag()->add('info', "Actualité supprimée avec succès");
    return $this->redirectToRoute('plateforme_core_page_actualites_crud');
  }

  /**
   * Voir l'actualite
   */
  public function viewAction($slug, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $actualite = $em->getRepository('PlateformeCoreBundle:PageActualite')->findOneBySlug($slug);
    if (null === $actualite) {
      throw new NotFoundHttpException("L'actualité ayant l'url " . $slug . " n'existe pas.");
    }
    return $this->render('PlateformeCoreBundle:PageActualite:view.html.twig', array(
          'actualite' => $actualite,
    ));
  }

}
