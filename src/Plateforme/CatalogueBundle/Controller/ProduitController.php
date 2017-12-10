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
   * Produits
   */
  public function indexAction(Request $request) {

    $em = $this->getDoctrine()->getManager();
    $produits = $em->getRepository('PlateformeCatalogueBundle:Produit')->findAll();

    // permettra de retirer le bouton d'ajout si le produit est déjà ajouter
    $session = $request->getSession();
    if ($session->has('panier')) {
      $panier = $session->get('panier');
    }
    else {
      $panier = false;
    }

    return $this->render('PlateformeCatalogueBundle:Produit:index.html.twig', array(
          'produits' => $produits,
          'panier' => $panier,
    ));
  }

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
      $em->persist($produit);
      $em->flush();
      $request->getSession()->getFlashBag()->add('info', "Produit créé avec succès");
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
    $produit = $em->getRepository('PlateformeCatalogueBundle:Produit')->find($id);
    if (null === $produit) {
      throw new NotFoundHttpException("Le produit ayant l'identifiant " . $id . " n'existe pas.");
    }
    $marques = $em->getRepository('PlateformeCatalogueBundle:Marque')->findAll();
    $tvas = $em->getRepository('PlateformeEcommerceBundle:Tva')->findAll();

    if ($request->isMethod('POST')) {
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
      $em->persist($produit);
      $em->flush();
      $request->getSession()->getFlashBag()->add('info', "Produit créé avec succès");
      return $this->redirectToRoute('plateforme_catalogue_produits_crud');
    }

    return $this->render('PlateformeCatalogueBundle:Produit:edit.html.twig', array(
          'produit' => $produit,
          'marques' => $marques,
          'tvas' => $tvas,
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
      $combinaisons = $this->getCombinaisons($produit, $valeurs_recu, array_keys($valeurs_recu), array());
      $request->getSession()->getFlashBag()->add('info', "Vos modifications ont bien été prises en compte.");
      return $this->redirectToRoute('plateforme_catalogue_produits_edit', array('id' => $id));
    }


    return $this->render('PlateformeCatalogueBundle:Produit:edit_declinaisons.html.twig', array(
          'produit' => $produit,
          'declinaisons' => $declinaisons,
          'attributs_categories' => $attributs_categories,
          'attributs' => $attributs,
    ));
    }

    public function getCombinaisons ($produit, $tab, $keys, $variantes) {
    if (count($keys) == 0) {
      //var_dump($variantes);
      $em = $this->getDoctrine()->getManager();
      $declinaison = new Declinaison();
      $declinaison->setProduit($produit);
      $declinaison->setCombinaison($variantes);
      $em->persist($declinaison);
      $em->flush();
      return;
    }
    $key = array_shift($keys);
    foreach ($tab[$key] as $e) {
      $tvariantes = $variantes;
      $tvariantes[] = $e;
      $this->getCombinaisons($produit, $tab, $keys, $tvariantes);
    }
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
    $request->getSession()->getFlashBag()->add('info', "Produit cloné avec succès");
    return $this->redirectToRoute('plateforme_catalogue_produits_crud');
  }

  /**
   * Formulaire de suppression d'un produit
   */
  public function deleteAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $produit = $em->getRepository('PlateformeCatalogueBundle:Produit')->find($id);
    if (null === $produit) {
      throw new NotFoundHttpException("Le produit ayant l'identifiant " . $id . " n'existe pas.");
    }
    $em->remove($produit);
    $em->flush();
    $request->getSession()->getFlashBag()->add('info', "Produit supprimé avec succès");
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

    // permettra de retirer le bouton d'ajout si le produit est déjà ajouter
    $session = $request->getSession();
    if ($session->has('panier')) {
      $panier = $session->get('panier');
    }
    else {
      $panier = false;
    }

    return $this->render('PlateformeCatalogueBundle:Produit:view.html.twig', array(
          'produit' => $produit,
          'panier' => $panier,
    ));
  }

  /**
   * Résultats d'une recherche en json
   *  FIXME: n'affiche pas de résultats si pas d'image
   *  exemple: http://localhost/plateforme/web/app_dev.php/produits/json?term=ecran
   * @param Request $request
   * @return JsonResponse
   */
  public function jsonAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $query = $request->query->get('term'); // Récupération du terme recherché ("ecran" dans l'exemple ci-dessus)
    if (!isset($query)) {
      die("Veuillez saisir un terme");
    }
    $status = true;
    // Récupération des produits
    //  Attention, par souci de performance s'il y a d'autres champs à ajouter 
    //  dans les résultats des recherche: il faudra les ajouter dans le select de la méthode "findLikeTitre"
    $produits = $em->getRepository('PlateformeCatalogueBundle:Produit')->findLikeTitre($query);
    $resultProduits = [];
    $baseurl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();
    foreach ($produits as $produit) {
      $resultProduits[] = array(
        'id' => $produit['id'],
        'produit' => $produit['titre'], // doit être le même nom que dans la réponse retourner (data)
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

}
