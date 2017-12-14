<?php

namespace Plateforme\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Plateforme\EcommerceBundle\Form\UtilisateursAdressesType;
use Plateforme\EcommerceBundle\Entity\UtilisateursAdresses;

class PanierController extends Controller {

  /**
   * Menu du panier (permet de compter notamment le nombre de produits)
   * @return type
   */
  public function menuAction(Request $request) {
    $session = $request->getSession();
    $nb_articles = 0;
    if ($session->has('panier')) {
      foreach ($session->get('panier') as $key => $article_ajoute) {
        if ($key != null) {
          $nb_articles += $article_ajoute['quantite'];
        }
      }
    }
    return $this->render('PlateformeEcommerceBundle:Panier:compteur.html.twig', array(
          'nb_articles' => $nb_articles
    ));
  }

  /**
   * Page Panier
   */
  public function panierAction(Request $request) {
    $session = $request->getSession();
    if (!$session->has('panier')) {
      $session->set('panier', array());
    }

    $em = $this->getDoctrine()->getManager();
    
    $lignes_paniers = array();
    foreach($session->get('panier') as $produit_id => $ligne_panier){
      $produit = $em->getRepository('PlateformeCatalogueBundle:Produit')->find($produit_id);
      if($ligne_panier['declinaison'] != 0){
        $declinaison = $em->getRepository('PlateformeCatalogueBundle:Declinaison')->find($ligne_panier['declinaison']);
        $lignes_paniers[] = array(
          'produit' => $produit,
          'designation' => $produit->getTitre() . '<br><span class="text-muted">' . $declinaison.'</span>',
          'prix_unitaire' => $declinaison->getPrix(),
          'quantite' => $ligne_panier['quantite'],
        );
      }else{
        $lignes_paniers[] = array(
          'produit' => $produit,
          'designation' => $produit->getTitre(),
          'prix_unitaire' => $produit->getPrix(),
          'quantite' => $ligne_panier['quantite'],
        );
      }
    }
    
    return $this->render('PlateformeEcommerceBundle:Panier:panier.html.twig', array(
          'lignes_paniers' => $lignes_paniers,
    ));
  }

  /**
   * Méthode pour vider le panier
   */
  public function viderAction(Request $request) {
    $session = $request->getSession();
    $session->set('panier', array());
    return $this->redirectToRoute('plateforme_ecommerce_tunnel_panier');
  }

  /**
   * Méthode pour actualiser les quantités du panier
   */
  public function refreshAction(Request $request) {
    $session = $request->getSession();
    $valeurs_recu = $request->request->all();
    if (!$session->has('panier')) {
      $session->set('panier', array());
    }
    $panier = $session->get('panier');
    foreach ($valeurs_recu['qte'] as $id => $quantite) {
      $panier[$id] = $quantite;
    }
    $session->set('panier', $panier);
    $this->get('session')->getFlashBag()->add('success', 'Votre panier a bien été actualisé.');
    return $this->redirectToRoute('plateforme_ecommerce_tunnel_panier');
  }

  /**
   * Méthode de suppression d'une ligne du panier
   */
  public function deleteAction($id, Request $request) {
    $session = $request->getSession();
    $panier = $session->get('panier');

    if (array_key_exists($id, $panier)) {
      unset($panier[$id]);
      $session->set('panier', $panier);
      $this->get('session')->getFlashBag()->add('success', 'Article supprimé avec succès');
    }

    return $this->redirectToRoute('plateforme_ecommerce_tunnel_panier');
  }

  /**
   * Méthode de changement de quantité d'une ligne de panier
   */
  public function addAction($id, Request $request) {
    $session = $request->getSession();
    $valeurs_recu = $request->request->all();

    if (!$session->has('panier')) {
      $session->set('panier', array());
    }
    $panier = $session->get('panier');

    if (array_key_exists($id, $panier)) {
      if ($request->query->get('qte') != null) {
        $panier[$id] = array(
          'quantite' => $request->query->get('qte'),
          'declinaison' => $valeurs_recu['declinaison_id'],
        );
      }
      $this->get('session')->getFlashBag()->add('success', 'Quantité modifié avec succès');
    }
    else {
      if ($request->query->get('qte') != null) {
        $panier[$id] = array(
          'quantite' => $request->query->get('qte'),
          'declinaison' => $valeurs_recu['declinaison_id'],
        );
      }
      else {
        $panier[$id] = array(
          'quantite' => 1,
          'declinaison' => $valeurs_recu['declinaison_id'],
        );
      }
      $this->get('session')->getFlashBag()->add('success', 'Article ajouté avec succès');
    }
    $session->set('panier', $panier);

    return $this->redirect($this->generateUrl('plateforme_ecommerce_tunnel_panier'));
  }

}
