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
          $nb_articles += $article_ajoute;
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
    $produits = $em->getRepository('PlateformeCatalogueBundle:Produit')->findArray(array_keys($session->get('panier')));

    return $this->render('PlateformeEcommerceBundle:Panier:panier.html.twig', array(
          'produits' => $produits,
          'panier' => $session->get('panier')
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
    if (!$session->has('panier')) {
      $session->set('panier', array());
    }
    $panier = $session->get('panier');

    if (array_key_exists($id, $panier)) {
      if ($request->query->get('qte') != null) {
        $panier[$id] = $request->query->get('qte');
      }
      $this->get('session')->getFlashBag()->add('success', 'Quantité modifié avec succès');
    }
    else {
      if ($request->query->get('qte') != null) {
        $panier[$id] = $request->query->get('qte');
      }
      else {
        $panier[$id] = 1;
      }
      $this->get('session')->getFlashBag()->add('success', 'Article ajouté avec succès');
    }
    $session->set('panier', $panier);
    return $this->redirect($this->generateUrl('plateforme_ecommerce_tunnel_panier'));
  }

}
