<?php

namespace Plateforme\CatalogueBundle\Controller;

use Plateforme\CatalogueBundle\Entity\Marque;
use Plateforme\CatalogueBundle\Form\MarqueType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;

class MarqueController extends Controller {

  /**
   * Marques
   */
  public function indexAction(Request $request) {

    $em = $this->getDoctrine()->getManager();
    $marques = $em->getRepository('PlateformeCatalogueBundle:Marque')->findBy(array(), array('titre' => 'ASC'));

    return $this->render('PlateformeCatalogueBundle:Marque:index.html.twig', array(
          'marques' => $marques,
    ));
  }

  /**
   * Gestion des marques
   */
  public function crudAction() {
    $em = $this->getDoctrine()->getManager();
    $marques = $em->getRepository('PlateformeCatalogueBundle:Marque')->findAll();

    return $this->render('PlateformeCatalogueBundle:Marque:crud.html.twig', array(
          'marques' => $marques,
    ));
  }

  /**
   * Formulaire de création d'un marque
   */
  public function addAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $marque = new Marque();
    $form = $this->get('form.factory')->create(MarqueType::class, $marque);

    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($marque);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', "Marque créée avec succès");
        return $this->redirectToRoute('plateforme_catalogue_marques_view', array('slug' => $marque->getSlug()));
      }
    }
    return $this->render('PlateformeCatalogueBundle:Marque:add.html.twig', array(
          'form' => $form->createView(),
    ));
  }

  /**
   * Formulaire d'édition d'un marque
   */
  public function editAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $marque = $em->getRepository('PlateformeCatalogueBundle:Marque')->find($id);
    if (null === $marque) {
      throw new NotFoundHttpException("La marque ayant l'identifiant " . $id . " n'existe pas.");
    }
    $form = $this->get('form.factory')->create(MarqueType::class, $marque);

    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($marque);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', "Marque modifiée avec succès");
        return $this->redirectToRoute('plateforme_catalogue_marques_crud');
      }
    }

    return $this->render('PlateformeCatalogueBundle:Marque:edit.html.twig', array(
          'marque' => $marque,
          'form' => $form->createView(),
    ));
  }

  /**
   * Formulaire pour cloner un marque
   */
  public function cloneAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $marque = $em->getRepository('PlateformeCatalogueBundle:Marque')->find($id);
    if (null === $marque) {
      throw new NotFoundHttpException("La marque ayant l'identifiant " . $id . " n'existe pas.");
    }
    $marque_clone = new Marque();
    $marque_clone->setTitre("[CLONE] " . $marque->getTitre());
    $marque_clone->setContenu($marque->getContenu());
    $em->persist($marque_clone);
    $em->flush();
    $request->getSession()->getFlashBag()->add('info', "Marque clonée avec succès");
    return $this->redirectToRoute('plateforme_catalogue_marques_crud');
  }

  /**
   * Formulaire de suppression d'un marque
   */
  public function deleteAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $marque = $em->getRepository('PlateformeCatalogueBundle:Marque')->find($id);
    if (null === $marque) {
      throw new NotFoundHttpException("La marque ayant l'identifiant " . $id . " n'existe pas.");
    }
    $em->remove($marque);
    $em->flush();
    $request->getSession()->getFlashBag()->add('info', "Marque supprimée avec succès");
    return $this->redirectToRoute('plateforme_catalogue_marques_crud');
  }

  /**
   * Fiche marque
   */
  public function viewAction($slug) {
    $em = $this->getDoctrine()->getManager();
    $marque = $em->getRepository('PlateformeCatalogueBundle:Marque')->findOneBySlug($slug);
    if (null === $marque) {
      throw new NotFoundHttpException("La marque ayant l'url " . $slug . " n'existe pas.");
    }
    $produits = $em->getRepository('PlateformeCatalogueBundle:Produit')->findByMarque($marque);

    return $this->render('PlateformeCatalogueBundle:Marque:view.html.twig', array(
          'marque' => $marque,
          'produits' => $produits,
    ));
  }

}
