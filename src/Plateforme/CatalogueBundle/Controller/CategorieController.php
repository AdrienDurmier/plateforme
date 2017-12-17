<?php

namespace Plateforme\CatalogueBundle\Controller;

use Plateforme\CatalogueBundle\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;

class CategorieController extends Controller {

  /**
   * Categories -> page "Nos categories"
   */
  public function indexAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $categories = $em->getRepository('PlateformeCatalogueBundle:Categorie')->findParents();
    return $this->render('PlateformeCatalogueBundle:Categorie:index.html.twig', array(
          'categories' => $categories,
    ));
  }

  /**
   * Fiche catégorie
   */
  public function viewAction($slug, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $categorie = $em->getRepository('PlateformeCatalogueBundle:Categorie')->findOneBySlug($slug);
    if (null === $categorie) {
      throw new NotFoundHttpException("La catégorie ayant le slug " . $slug . " n'existe pas.");
    }
    $categories_enfants = $em->getRepository('PlateformeCatalogueBundle:Categorie')->findEnfants($categorie->getId());
    $produits = $categorie->getProduits();
    return $this->render('PlateformeCatalogueBundle:Categorie:view.html.twig', array(
          'categorie' => $categorie,
          'categories_enfants' => $categories_enfants,
          'produits' => $produits,
    ));
  }

  /**
   * Gestion des catégories parents
   */
  public function crudAction() {
    $em = $this->getDoctrine()->getManager();
    $categories = $em->getRepository('PlateformeCatalogueBundle:Categorie')->findParents();
    return $this->render('PlateformeCatalogueBundle:Categorie:crud.html.twig', array(
          'categories' => $categories,
    ));
  }

  /**
   * Gestion des catégories enfants
   */
  public function crudEnfantsAction($id) {
    $em = $this->getDoctrine()->getManager();
    $categorie = $em->getRepository('PlateformeCatalogueBundle:Categorie')->find($id);
    if (null === $categorie) {
      throw new NotFoundHttpException("La catégorie ayant l'identifiant " . $id . " n'existe pas.");
    }
    $categories_enfants = $em->getRepository('PlateformeCatalogueBundle:Categorie')->findEnfants($id);
    return $this->render('PlateformeCatalogueBundle:Categorie:crud_enfants.html.twig', array(
          'categorie' => $categorie,
          'categories_enfants' => $categories_enfants,
    ));
  }

  /**
   * Formulaire de création d'un categorie
   */
  public function addAction(Request $request) {
    $em = $this->getDoctrine()->getManager();

    if ($request->isMethod('POST')) {
      $categorie = new Categorie();
      $valeurs_recu = $request->request->all();
      $categorie->setTitre($valeurs_recu['titre']);
      $categorie->setContenu($valeurs_recu['contenu']);
      if ($valeurs_recu['metatitle'] == null || $valeurs_recu['metatitle'] == '') {
        $categorie->setMetatitle($valeurs_recu['titre']);
      }
      else {
        $categorie->setMetatitle($valeurs_recu['metatitle']);
      }
      if ($valeurs_recu['metadescription'] == null || $valeurs_recu['metadescription'] == '') {
        $categorie->setMetadescription(substr($valeurs_recu['contenu'], 0, 165));
      }
      else {
        $categorie->setMetadescription($valeurs_recu['metadescription']);
      }
      $em->persist($categorie);
      $em->flush();
      $request->getSession()->getFlashBag()->add('success', "Catégorie créée avec succès");
      return $this->redirectToRoute('plateforme_catalogue_categories_crud');
    }

    return $this->render('PlateformeCatalogueBundle:Categorie:add.html.twig');
  }

  /**
   * Formulaire d'édition d'une catégorie
   */
  public function editAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $categorie = $em->getRepository('PlateformeCatalogueBundle:Categorie')->find($id);
    if (null === $categorie) {
      throw new NotFoundHttpException("La catégorie ayant l'identifiant " . $id . " n'existe pas.");
    }

    if ($request->isMethod('POST')) {
      $valeurs_recu = $request->request->all();
      $categorie->setTitre($valeurs_recu['titre']);
      $categorie->setContenu($valeurs_recu['contenu']);
      if ($valeurs_recu['metatitle'] == null || $valeurs_recu['metatitle'] == '') {
        $categorie->setMetatitle($valeurs_recu['titre']);
      }
      else {
        $categorie->setMetatitle($valeurs_recu['metatitle']);
      }
      if ($valeurs_recu['metadescription'] == null || $valeurs_recu['metadescription'] == '') {
        $categorie->setMetadescription(substr($valeurs_recu['contenu'], 0, 165));
      }
      else {
        $categorie->setMetadescription($valeurs_recu['metadescription']);
      }
      $em->persist($categorie);
      $em->flush();
      $request->getSession()->getFlashBag()->add('success', "Catégorie modifiée avec succès");
      return $this->redirectToRoute('plateforme_catalogue_categories_crud');
    }

    return $this->render('PlateformeCatalogueBundle:Categorie:edit.html.twig', array(
          'categorie' => $categorie,
    ));
  }

  /**
   * Formulaire pour cloner une catégorie
   */
  public function cloneAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $categorie = $em->getRepository('PlateformeCatalogueBundle:Categorie')->find($id);
    if (null === $categorie) {
      throw new NotFoundHttpException("La catégorie ayant l'identifiant " . $id . " n'existe pas.");
    }
    $categorie_clone = new Categorie();
    $categorie_clone->setTitre("[CLONE] " . $categorie->getTitre());
    $categorie_clone->setContenu($categorie->getContenu());
    $em->persist($categorie_clone);
    $em->flush();
    $request->getSession()->getFlashBag()->add('success', "Catégorie clonée avec succès");
    return $this->redirectToRoute('plateforme_catalogue_categories_crud');
  }

  /**
   * Suppression d'une catégorie
   */
  public function deleteAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $categorie = $em->getRepository('PlateformeCatalogueBundle:Categorie')->find($id);
    if (null === $categorie) {
      throw new NotFoundHttpException("La catégorie ayant l'identifiant " . $id . " n'existe pas.");
    }
    $em->remove($categorie);
    $em->flush();
    $request->getSession()->getFlashBag()->add('success', "Catégorie supprimée avec succès");
    return $this->redirectToRoute('plateforme_catalogue_categories_crud');
  }

  /**
   * Résultats d'une recherche en json utilisé pour l'autocomplétion
   */
  public function jsonAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $query = $request->query->get('term');  // Récupération du terme recherché
    $limit = $request->query->get('limit'); // Récupération du nombre maximum de résultats
    if (!isset($query)) {
      die("Veuillez saisir un terme");
    }
    $status = true;
    // Récupération des produits
    $categories = $em->getRepository('PlateformeCatalogueBundle:Categorie')->findLikeTitre($query, $limit);
    $results = [];
    foreach ($categories as $categorie) {
      $results[] = array(
        'id' => $categorie['id'],
        'titre' => $categorie['titre'], // doit être le même nom que dans la réponse retourner (data)
        'slug' => $categorie['slug'], // doit être le même nom que dans la réponse retourner (data)
      );
    }
    // S'il n'y a eu aucun résultat
    if (empty($results)) {
      $status = false;
    }
    $response = array(
      'success' => $status,
      'data' => array(
        'produit' => $results
      )
    );
    return new JsonResponse($response);
  }

}
