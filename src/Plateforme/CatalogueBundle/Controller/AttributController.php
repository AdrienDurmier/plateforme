<?php

namespace Plateforme\CatalogueBundle\Controller;

use Plateforme\CatalogueBundle\Entity\Attribut;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AttributController extends Controller {

  /**
   * Gestion des attributs
   */
  public function crudAction($id) {
    $em = $this->getDoctrine()->getManager();
    $categorie = $em->getRepository('PlateformeCatalogueBundle:AttributCategorie')->find($id);
    if (null === $categorie) {
      throw new NotFoundHttpException("La catégorie d'attributs ayant l'identifiant " . $id . " n'existe pas.");
    }

    $attributs = $em->getRepository('PlateformeCatalogueBundle:Attribut')->findByCategorie($categorie);

    return $this->render('PlateformeCatalogueBundle:Attribut:crud.html.twig', array(
          'categorie' => $categorie,
          'attributs' => $attributs,
    ));
  }

  /**
   * Formulaire de création d'un attribut
   */
  public function addAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $categorie = $em->getRepository('PlateformeCatalogueBundle:AttributCategorie')->find($id);
    if (null === $categorie) {
      throw new NotFoundHttpException("La catégorie d'attributs ayant l'identifiant " . $id . " n'existe pas.");
    }
    $attribut = new Attribut();

    if ($request->isMethod('POST')) {
      $valeurs_recu = $request->request->all();
      $attribut = new Attribut();
      $attribut->setValeur($valeurs_recu['valeur']);
      if (isset($valeurs_recu['couleur'])) {
        $attribut->setCouleur($valeurs_recu['couleur']);
      }
      $attribut->setCategorie($categorie);
      $em->persist($attribut);
      $em->flush();
      $request->getSession()->getFlashBag()->add('success', "Attribut créé avec succès");
      return $this->redirectToRoute('plateforme_catalogue_attributs_categories_categorie', array(
            'id' => $categorie->getId(),
      ));
    }
    return $this->render('PlateformeCatalogueBundle:Attribut:add.html.twig', array(
          'categorie' => $categorie,
    ));
  }

  /**
   * Formulaire d'édition d'un attribut
   */
  public function editAction($categorie_id, $attribut_id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $attribut = $em->getRepository('PlateformeCatalogueBundle:Attribut')->find($attribut_id);
    if (null === $attribut) {
      throw new NotFoundHttpException("L'attribut ayant l'identifiant " . $attribut_id . " n'existe pas.");
    }
    $categorie = $em->getRepository('PlateformeCatalogueBundle:AttributCategorie')->find($categorie_id);
    if (null === $categorie) {
      throw new NotFoundHttpException("La catégorie d'attributs ayant l'identifiant " . $categorie_id . " n'existe pas.");
    }
    if ($request->isMethod('POST')) {
      $valeurs_recu = $request->request->all();
      $attribut->setValeur($valeurs_recu['valeur']);
      if (isset($valeurs_recu['couleur'])) {
        $attribut->setCouleur($valeurs_recu['couleur']);
      }
      $attribut->setCategorie($categorie);
      $em->persist($attribut);
      $em->flush();
      $request->getSession()->getFlashBag()->add('success', "Attribut modifié avec succès");
      return $this->redirectToRoute('plateforme_catalogue_attributs_categories_categorie', array(
            'id' => $categorie_id,
      ));
    }

    return $this->render('PlateformeCatalogueBundle:Attribut:edit.html.twig', array(
          'categorie' => $categorie,
          'attribut' => $attribut,
    ));
  }

  /**
   * Formulaire de suppression d'un attribut
   */
  public function deleteAction($categorie_id, $attribut_id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $attribut = $em->getRepository('PlateformeCatalogueBundle:Attribut')->find($attribut_id);
    if (null === $attribut) {
      throw new NotFoundHttpException("L'attribut ayant l'identifiant " . $attribut_id . " n'existe pas.");
    }
    $em->remove($attribut);
    $em->flush();
    $request->getSession()->getFlashBag()->add('success', "Attribut supprimé avec succès");
    return $this->redirectToRoute('plateforme_catalogue_attributs_categories_categorie', array(
          'id' => $categorie_id,
    ));
  }

}
