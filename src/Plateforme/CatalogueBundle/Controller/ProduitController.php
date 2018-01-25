<?php

namespace Plateforme\CatalogueBundle\Controller;

use Plateforme\CatalogueBundle\Entity\Produit;
use Plateforme\CatalogueBundle\Entity\Declinaison;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProduitController extends Controller {

  /**
   * Gestion des produits
   */
  public function crudAction() {
    $em = $this->getDoctrine()->getManager();
    $produits = $em->getRepository('PlateformeCatalogueBundle:Produit')->findAll();

    return $this->render('PlateformeCatalogueBundle:Produit:crud.html.twig', array(
          'produits' => $produits,
    ));
  }

  /**
   * Formulaire de création d'un produit
   */
  public function addAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $marques = $em->getRepository('PlateformeCatalogueBundle:Marque')->findAll();
    $tvas = $em->getRepository('PlateformeEcommerceBundle:Tva')->findAll();

    if ($request->isMethod('POST')) {
      $produit = new Produit();
      $valeurs_recu = $request->request->all();
      $produit->setTitre($valeurs_recu['titre']);
      $produit->setContenu($valeurs_recu['contenu']);
      $marque = $em->getRepository('PlateformeCatalogueBundle:Marque')->find($valeurs_recu['marque']);
      $produit->setMarque($marque);
      $produit->setPrix($valeurs_recu['prix']);
      $tva = $em->getRepository('PlateformeEcommerceBundle:Tva')->find($valeurs_recu['tva']);
      $produit->setTva($tva);
      $produit->setPoids($valeurs_recu['poids']);
      if ($valeurs_recu['metatitle'] == null || $valeurs_recu['metatitle'] == '') {
        $produit->setMetatitle($valeurs_recu['titre']);
      }
      else {
        $produit->setMetatitle($valeurs_recu['metatitle']);
      }
      if ($valeurs_recu['metadescription'] == null || $valeurs_recu['metadescription'] == '') {
        $produit->setMetadescription(substr($valeurs_recu['contenu'], 0, 165));
      }
      else {
        $produit->setMetadescription($valeurs_recu['metadescription']);
      }
      // Versionnement
      $service_versionner = $this->container->get('core_page');
      $service_versionner->versionner($produit);

      $em->persist($produit);
      $em->flush();
      $request->getSession()->getFlashBag()->add('success', "Produit créé avec succès");
      return $this->redirectToRoute('plateforme_catalogue_produits_crud');
    }

    return $this->render('PlateformeCatalogueBundle:Produit:add.html.twig', array(
          'marques' => $marques,
          'tvas' => $tvas,
    ));
  }

  /**
   * Formulaire d'édition d'un produit
   */
  public function editAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $produit_original = $em->getRepository('PlateformeCatalogueBundle:Produit')->find($id);
    if (null === $produit_original) {
      throw new NotFoundHttpException("Le produit ayant l'identifiant " . $id . " n'existe pas.");
    }
    $marques = $em->getRepository('PlateformeCatalogueBundle:Marque')->findAll();
    $tvas = $em->getRepository('PlateformeEcommerceBundle:Tva')->findAll();

    if ($request->isMethod('POST')) {
      $produit = new Produit();
      $valeurs_recu = $request->request->all();
      $produit->setTitre($valeurs_recu['titre']);
      $produit->setContenu($valeurs_recu['contenu']);
      $marque = $em->getRepository('PlateformeCatalogueBundle:Marque')->find($valeurs_recu['marque']);
      $produit->setMarque($marque);
      $produit->setStock($valeurs_recu['stock']);
      $produit->setPrix($valeurs_recu['prix']);
      $tva = $em->getRepository('PlateformeEcommerceBundle:Tva')->find($valeurs_recu['tva']);
      $produit->setTva($tva);
      $produit->setPoids($valeurs_recu['poids']);
      if ($valeurs_recu['metatitle'] == null || $valeurs_recu['metatitle'] == '') {
        $produit->setMetatitle($valeurs_recu['titre']);
      }
      else {
        $produit->setMetatitle($valeurs_recu['metatitle']);
      }
      if ($valeurs_recu['metadescription'] == null || $valeurs_recu['metadescription'] == '') {
        $produit->setMetadescription(substr($valeurs_recu['contenu'], 0, 165));
      }
      else {
        $produit->setMetadescription($valeurs_recu['metadescription']);
      }
      // Versionnement
      $service_versionner = $this->container->get('core_page');
      $service_versionner->versionner($produit_original, $produit);
      
      $em->persist($produit);
      $em->flush();
      $request->getSession()->getFlashBag()->add('success', "Produit modifié avec succès");
      return $this->redirectToRoute('plateforme_catalogue_produits_crud');
    }

    return $this->render('PlateformeCatalogueBundle:Produit:edit.html.twig', array(
          'produit' => $produit_original,
          'marques' => $marques,
          'tvas' => $tvas,
    ));
  }

  /**
   * Formulaire pour cloner un produit
   */
  public function cloneAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $produit = $em->getRepository('PlateformeCatalogueBundle:Produit')->find($id);
    if (null === $produit) {
      throw new NotFoundHttpException("Le produit ayant l'identifiant " . $id . " n'existe pas.");
    }
    $produit_clone = new Produit();
    $produit_clone->setTitre("[CLONE] " . $produit->getTitre());
    $produit_clone->setContenu($produit->getContenu());
    $em->persist($produit_clone);
    $em->flush();
    $request->getSession()->getFlashBag()->add('success', "Produit cloné avec succès");
    return $this->redirectToRoute('plateforme_catalogue_produits_crud');
  }

  /**
   * Suppression d'un produit
   */
  public function deleteAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $produit = $em->getRepository('PlateformeCatalogueBundle:Produit')->find($id);
    if (null === $produit) {
      throw new NotFoundHttpException("Le produit ayant l'identifiant " . $id . " n'existe pas.");
    }
    $em->remove($produit);
    $em->flush();
    $request->getSession()->getFlashBag()->add('success', "Produit supprimé avec succès");
    return $this->redirectToRoute('plateforme_catalogue_produits_crud');
  }

  /**
   * Fiche produit
   */
  public function viewAction($slug, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $produit = $em->getRepository('PlateformeCatalogueBundle:Produit')->findOneBySlug($slug);
    if (null === $produit) {
      throw new NotFoundHttpException("Le produit ayant l'url " . $slug . " n'existe pas.");
    }
    // Récupére uniquement les attributs présents dans des déclinaisons de produits
    // o_O Optimisable ? ça fait beaucoup de boucles quand même !!
    $attribut_categories = $em->getRepository('PlateformeCatalogueBundle:AttributCategorie')->findAll();
    $declinaisons = $em->getRepository('PlateformeCatalogueBundle:Declinaison')->findByProduit($produit);
    $attributs_en_declinaisons = array();
    foreach ($declinaisons as $declinaison) {
      foreach ($declinaison->getCombinaison() as $combinaison) {
        $attributs_en_declinaisons[$combinaison->getCategorie()->getId()] = $combinaison->getCategorie();
      }
    }
    $attributes_by_categorie = array();
    foreach ($attributs_en_declinaisons as $categorie) {
      foreach ($declinaisons as $declinaison) {
        foreach ($declinaison->getCombinaison() as $combinaison) {
          if ($combinaison->getCategorie()->getId() == $categorie->getId()) {
            if (isset($attributes_by_categorie[$categorie->getMachine()]) && in_array($combinaison->getValeur(), $attributes_by_categorie[$categorie->getMachine()])) {
              continue;
            }
            else {
              $attributes_by_categorie[$categorie->getMachine()][] = $combinaison->getValeur();
            }
          }
        }
      }
    }

    // Permettra de retirer le bouton d'ajout si le produit est déjà ajouter
    $session = $request->getSession();
    if ($session->has('panier')) {
      $panier = $session->get('panier');
    }
    else {
      $panier = false;
    }

    return $this->render('PlateformeCatalogueBundle:Produit:view.html.twig', array(
          'produit' => $produit,
          'declinaisons' => $declinaisons,
          'attributes_by_categorie' => $attributes_by_categorie,
          'panier' => $panier,
    ));
  }

  /**
   * Résultats d'une recherche en json utilisé pour l'autocomplétion
   */
  public function jsonAction(Request $request) {
    $em = $this->getDoctrine()->getManager();

    $query = $request->query->get('term'); // Récupération du terme recherché
    $limit = $request->query->get('limit'); // Récupération du nombre maximum de résultats

    if (!isset($query)) {
      die("Veuillez saisir un terme");
    }
    $status = true;
    // Récupération des produits
    //  Attention, par souci de performance s'il y a d'autres champs à ajouter 
    //  dans les résultats des recherche: il faudra les ajouter dans le select de la méthode "findLikeTitre"
    $produits = $em->getRepository('PlateformeCatalogueBundle:Produit')->findLikeTitre($query, $limit);
    $resultProduits = [];
    $baseurl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();
    foreach ($produits as $produit) {
      $resultProduits[] = array(
        'id' => $produit['id'],
        'titre' => $produit['titre'], // doit être le même nom que dans la réponse retourner (data)
        'slug' => $produit['slug'], // doit être le même nom que dans la réponse retourner (data)
        'image' => $baseurl . '/uploads/img/' . $produit['filename'], // doit être le même nom que dans la réponse retourner (data)
      );
    }
    // S'il n'y a eu aucun résultat
    if (empty($resultProduits)) {
      $status = false;
    }
    $response = array(
      'success' => $status,
      'data' => array(
        'produit' => $resultProduits
      )
    );
    return new JsonResponse($response);
  }

  /**
   * Page de résultats de recherche
   */
  public function resultatsAction($term, Request $request) {
    $em = $this->getDoctrine()->getManager();
    if (!isset($term)) {
      die("Veuillez saisir un terme");
    }

    // Si le terme recherché est un identifiant alors on redirige directement vers la fiche de la déclinaison
    $produit = $em->getRepository('PlateformeCatalogueBundle:Produit')->find($term);
    if ($produit) {
      return $this->redirectToRoute('plateforme_catalogue_produits_view', array(
            'slug' => $produit->getSlug(),
      ));
    }
    // Sinon il faut récupérer la liste des résultats possibles
    $produits = $em->getRepository('PlateformeCatalogueBundle:Produit')->findLikeTitre($term, null);
    $resultProduits = [];
    foreach ($produits as $produit_result) {
      $produit = $em->getRepository('PlateformeCatalogueBundle:Produit')->find($produit_result['id']);
      $resultProduits[] = $produit;
    }

    return $this->render('PlateformeCatalogueBundle:Produit:resultats.html.twig', array(
          'produits' => $resultProduits,
          'term' => $term,
    ));
  }

  /**
   * Formulaire d'édition des déclinaisons d'un produit
   */
  public function editDeclinaisonsAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $produit = $em->getRepository('PlateformeCatalogueBundle:Produit')->find($id);
    if (null === $produit) {
      throw new NotFoundHttpException("Le produit ayant l'identifiant " . $id . " n'existe pas.");
    }
    $attributs_categories = $em->getRepository('PlateformeCatalogueBundle:AttributCategorie')->findAll();
    $attributs = $em->getRepository('PlateformeCatalogueBundle:Attribut')->findAll();
    $declinaisons = $em->getRepository('PlateformeCatalogueBundle:Declinaison')->findByProduit($produit);

    if ($request->isMethod('POST')) {
      $valeurs_recu = $request->request->all();
      $combinaisons = $this->generateDeclinaisons($produit, $valeurs_recu, array_keys($valeurs_recu), array());
      $request->getSession()->getFlashBag()->add('success', "Déclinaisons générées avec succès.");
      return $this->redirectToRoute('plateforme_catalogue_produits_edit_declinaisons', array('id' => $id));
    }

    return $this->render('PlateformeCatalogueBundle:Produit:edit_declinaisons.html.twig', array(
          'produit' => $produit,
          'declinaisons' => $declinaisons,
          'attributs_categories' => $attributs_categories,
          'attributs' => $attributs,
    ));
  }

  public function generateDeclinaisons($produit, $tab, $keys, $variantes) {
    $em = $this->getDoctrine()->getManager();
    if (count($keys) == 0) {
      //var_dump($variantes);
      $declinaison = new Declinaison();
      $declinaison->setProduit($produit);
      $declinaison->setPrix($produit->getPrix());
      $declinaison->setPoids($produit->getPoids());
      $declinaison->setStock($produit->getStock());
      $declinaison->setCombinaison($variantes);
      $em->persist($declinaison);
      $em->flush();
      return;
    }
    $key = array_shift($keys);
    foreach ($tab[$key] as $attribut_value) {
      $attribut_categorie = $em->getRepository('PlateformeCatalogueBundle:AttributCategorie')->findOneByMachine($key);
      $attribut = $em->getRepository('PlateformeCatalogueBundle:Attribut')->findOneBy(array(
        'categorie' => $attribut_categorie,
        'valeur' => $attribut_value,
      ));
      $tvariantes = $variantes;
      $tvariantes[] = $attribut;
      $this->generateDeclinaisons($produit, $tab, $keys, $tvariantes);
    }
  }

  /**
   * Édition d'une seule déclinaison
   */
  public function editDeclinaisonAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $produit = $em->getRepository('PlateformeCatalogueBundle:Produit')->find($id);
    if (null === $produit) {
      throw new NotFoundHttpException("Le produit ayant l'identifiant " . $id . " n'existe pas.");
    }
    $valeurs_recu = $request->request->all();
    $declinaison = $em->getRepository('PlateformeCatalogueBundle:Declinaison')->find($valeurs_recu['declinaison_id']);
    $declinaison->setPrix($valeurs_recu['declinaison_prix']);
    $declinaison->setPoids($valeurs_recu['declinaison_poids']);
    $declinaison->setStock($valeurs_recu['declinaison_stock']);
    $em->persist($declinaison);
    $em->flush();
    $request->getSession()->getFlashBag()->add('success', "Déclinaison modifiée avec succès");
    return $this->redirectToRoute('plateforme_catalogue_produits_edit_declinaisons', array('id' => $id, 'declinaison_id' => $valeurs_recu['declinaison_id']));
  }

  /**
   * Suppression d'une déclinaison
   */
  public function deleteDeclinaisonAction($id, $declinaison_id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $produit = $em->getRepository('PlateformeCatalogueBundle:Produit')->find($id);
    if (null === $produit) {
      throw new NotFoundHttpException("Le produit ayant l'identifiant " . $id . " n'existe pas.");
    }
    $declinaison = $em->getRepository('PlateformeCatalogueBundle:Declinaison')->find($declinaison_id);
    if (null === $declinaison) {
      throw new NotFoundHttpException("La déclinaison ayant l'identifiant " . $id . " n'existe pas.");
    }
    $em->remove($declinaison);
    $em->flush();
    $request->getSession()->getFlashBag()->add('success', "Déclinaison supprimée avec succès");
    return $this->redirectToRoute('plateforme_catalogue_produits_edit_declinaisons', array('id' => $id, 'declinaison_id' => $declinaison_id));
  }

  /**
   * Suppression de toutes les déclinaisons
   */
  public function deleteDeclinaisonsAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $produit = $em->getRepository('PlateformeCatalogueBundle:Produit')->find($id);
    if (null === $produit) {
      throw new NotFoundHttpException("Le produit ayant l'identifiant " . $id . " n'existe pas.");
    }
    $declinaisons = $em->getRepository('PlateformeCatalogueBundle:Declinaison')->findByProduit($produit);
    foreach ($declinaisons as $declinaison) {
      $em->remove($declinaison);
    }
    $em->flush();
    $request->getSession()->getFlashBag()->add('success', "Déclinaison supprimée avec succès");
    return $this->redirectToRoute('plateforme_catalogue_produits_edit_declinaisons', array('id' => $id));
  }

  /*
   * Mise à jour d'un produit à partir de la declinaison déduite avec les combinaisons saisies
   */

  public function majFicheProduitAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $valeurs_recu = $request->request->all();
    $declinaison = $em->getRepository('PlateformeCatalogueBundle:Declinaison')->findOneByCombinaisons($valeurs_recu);

    $response = array(
      'id' => $declinaison->getId(),
      'prix' => $declinaison->getPrix(),
      'stock' => $declinaison->getStock(),
    );
    return new JsonResponse($response);
  }

  /**
   * Ajout d'une liaison entre ce produit et une catégorie
   */
  public function addCategorieAction($id_produit, $id_categorie, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $produit = $em->getRepository('PlateformeCatalogueBundle:Produit')->find($id_produit);
    if (null === $produit) {
      throw new NotFoundHttpException("Le produit ayant l'identifiant " . $id_produit . " n'existe pas.");
    }
    $categorie = $em->getRepository('PlateformeCatalogueBundle:Categorie')->find($id_categorie);
    if (null === $categorie) {
      throw new NotFoundHttpException("La catégorie ayant l'identifiant " . $id_categorie . " n'existe pas.");
    }
    $produit->addCategory($categorie);
    $em->persist($produit);
    $em->flush();
    $request->getSession()->getFlashBag()->add('success', "Liaison ajoutée avec succès.");
    return $this->redirectToRoute('plateforme_catalogue_produits_edit', array('id' => $id_produit));
  }

  /**
   * Suppression d'une liaison entre ce produit et une catégorie
   */
  public function removeCategorieAction($id_produit, $id_categorie, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $produit = $em->getRepository('PlateformeCatalogueBundle:Produit')->find($id_produit);
    if (null === $produit) {
      throw new NotFoundHttpException("Le produit ayant l'identifiant " . $id_produit . " n'existe pas.");
    }
    $categorie = $em->getRepository('PlateformeCatalogueBundle:Categorie')->find($id_categorie);
    if (null === $categorie) {
      throw new NotFoundHttpException("La catégorie ayant l'identifiant " . $id_categorie . " n'existe pas.");
    }
    $produit->removeCategory($categorie);
    $em->persist($produit);
    $em->flush();
    $request->getSession()->getFlashBag()->add('success', "Liaison supprimée avec succès.");
    return $this->redirectToRoute('plateforme_catalogue_produits_edit', array('id' => $id_produit));
  }

}
