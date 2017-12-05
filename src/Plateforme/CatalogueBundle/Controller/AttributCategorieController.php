<?php

namespace Plateforme\CatalogueBundle\Controller;

use Plateforme\CatalogueBundle\Entity\AttributCategorie;
use Plateforme\CatalogueBundle\Form\AttributCategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AttributCategorieController extends Controller {

  /**
   * Gestion des attributs
   */
  public function crudAction() {
    $em = $this->getDoctrine()->getManager();
    $categories = $em->getRepository('PlateformeCatalogueBundle:AttributCategorie')->findAll();

    return $this->render('PlateformeCatalogueBundle:AttributCategorie:crud.html.twig', array(
          'categories' => $categories,
    ));
  }

  /**
   * Formulaire de création d'un attribut
   */
  public function addAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $categorie = new AttributCategorie();
    $form = $this->get('form.factory')->create(AttributCategorieType::class, $categorie);

    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($categorie);
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', "Categorie d'attribut créée avec succès");
        return $this->redirectToRoute('plateforme_catalogue_attributs_categories_crud');
      }
    }
    return $this->render('PlateformeCatalogueBundle:AttributCategorie:add.html.twig', array(
          'form' => $form->createView(),
    ));
  }

  /**
   * Formulaire d'édition d'un attribut
   */
  public function editAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $categorie = $em->getRepository('PlateformeCatalogueBundle:AttributCategorie')->find($id);
    if (null === $categorie) {
      throw new NotFoundHttpException("L'attribut ayant l'identifiant " . $id . " n'existe pas.");
    }
    $form = $this->get('form.factory')->create(AttributCategorieType::class, $categorie);

    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($categorie);
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', "La catégorie d'attribut a été modifié avec succès");
        return $this->redirectToRoute('plateforme_catalogue_attributs_categories_crud');
      }
    }

    return $this->render('PlateformeCatalogueBundle:AttributCategorie:edit.html.twig', array(
          'categorie' => $categorie,
          'form' => $form->createView(),
    ));
  }

  /**
   * Formulaire de suppression d'un attribut
   */
  public function deleteAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $categorie = $em->getRepository('PlateformeCatalogueBundle:AttributCategorie')->find($id);
    if (null === $categorie) {
      throw new NotFoundHttpException("La catégorie d'attribut ayant l'identifiant " . $id . " n'existe pas.");
    }
    $em->remove($categorie);
    $em->flush();
    $request->getSession()->getFlashBag()->add('success', "AttributCategorie supprimé avec succès");
    return $this->redirectToRoute('plateforme_catalogue_attributs_categories_crud');
  }

}
