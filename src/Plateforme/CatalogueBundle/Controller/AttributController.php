<?php

namespace Plateforme\CatalogueBundle\Controller;

use Plateforme\CatalogueBundle\Entity\Attribut;
use Plateforme\CatalogueBundle\Form\AttributType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AttributController extends Controller {

  /**
   * Gestion des attributs
   */
  public function crudAction() {
    $em = $this->getDoctrine()->getManager();
    $attributs = $em->getRepository('PlateformeCatalogueBundle:Attribut')->findAll();

    return $this->render('PlateformeCatalogueBundle:Attribut:crud.html.twig', array(
          'attributs' => $attributs,
    ));
  }

  /**
   * Formulaire de création d'un attribut
   */
  public function addAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $attribut = new Attribut();
    $form = $this->get('form.factory')->create(AttributType::class, $attribut);

    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($attribut);
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', "Attribut créé avec succès");
        return $this->redirectToRoute('plateforme_catalogue_attributs_crud');
      }
    }
    return $this->render('PlateformeCatalogueBundle:Attribut:add.html.twig', array(
          'form' => $form->createView(),
    ));
  }

  /**
   * Formulaire d'édition d'un attribut
   */
  public function editAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $attribut = $em->getRepository('PlateformeCatalogueBundle:Attribut')->find($id);
    if (null === $attribut) {
      throw new NotFoundHttpException("L'attribut ayant l'identifiant " . $id . " n'existe pas.");
    }
    $form = $this->get('form.factory')->create(AttributType::class, $attribut);

    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($attribut);
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', "Attribut modifié avec succès");
        return $this->redirectToRoute('plateforme_catalogue_attributs_crud');
      }
    }

    return $this->render('PlateformeCatalogueBundle:Attribut:edit.html.twig', array(
          'attribut' => $attribut,
          'form' => $form->createView(),
    ));
  }

  /**
   * Formulaire de suppression d'un attribut
   */
  public function deleteAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $attribut = $em->getRepository('PlateformeCatalogueBundle:Attribut')->find($id);
    if (null === $attribut) {
      throw new NotFoundHttpException("L'attribut ayant l'identifiant " . $id . " n'existe pas.");
    }
    $em->remove($attribut);
    $em->flush();
    $request->getSession()->getFlashBag()->add('success', "Attribut supprimé avec succès");
    return $this->redirectToRoute('plateforme_catalogue_attributs_crud');
  }

}
