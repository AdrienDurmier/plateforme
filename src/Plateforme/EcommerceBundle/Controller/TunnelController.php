<?php

namespace Plateforme\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class TunnelController extends Controller {

  public function authentificationAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    
    // Si le client est déjà connecté alors il est redirigé vers la l'étape suivante
    $user = $this->getUser();
    if($user) {
      return $this->redirect($this->generateUrl('plateforme_ecommerce_tunnel_livraison'));
    }
    
    return $this->render('PlateformeEcommerceBundle:Tunnel:authentification.html.twig', array(
      'user'  =>  $user,
    ));
  }
  
  public function validationAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $valeurs_recu = $request->request->all();
    $session = $request->getSession();
    // Si le panier n'existe pas alors on redirige vers la page panier
    if (!$session->has('panier')) {
      return $this->redirectToRoute('plateforme_ecommerce_tunnel_panier');
    }
    // print '<pre>';print_r($valeurs_recu);print '</pre>';die();
    
    $session->set('mode_livraison', $valeurs_recu['mode_livraison']);
    $session->set('tarif_livraison', $valeurs_recu['tarif_livraison_input']);
    // Par défaut il n'y a aucune taxe sur les frais de port sauf si c'est un collisimo
    $tva = $em->getRepository('PlateformeEcommerceBundle:Tva')->findOneByMultiplicate(1);  // Aucune taxe
    if($valeurs_recu['mode_livraison'] == 'livraison_laposte_colissimo'){
      $tva = $em->getRepository('PlateformeEcommerceBundle:Tva')->findOneByMultiplicate(1.2);// TVA 20%
    }
    $session->set('tva_livraison', $tva);
    $session->set('adresse_livraison', array(
      'livraison_nom'         => $valeurs_recu['livraison_nom'],
      'livraison_prenom'      => $valeurs_recu['livraison_prenom'],
      'livraison_adresse'     => $valeurs_recu['livraison_adresse'],
      'livraison_complement'  => $valeurs_recu['livraison_complement'],
      'livraison_cp'          => $valeurs_recu['livraison_cp'],
      'livraison_commune'     => $valeurs_recu['livraison_commune'],
      'livraison_pays'        => $valeurs_recu['livraison_pays'],
    ));
    $session->set('adresse_facturation', array(
      'facturation_nom'         => $valeurs_recu['facturation_nom'],
      'facturation_prenom'      => $valeurs_recu['facturation_prenom'],
      'facturation_adresse'     => $valeurs_recu['facturation_adresse'],
      'facturation_complement'  => $valeurs_recu['facturation_complement'],
      'facturation_cp'          => $valeurs_recu['facturation_cp'],
      'facturation_commune'     => $valeurs_recu['facturation_commune'],
      'facturation_pays'        => $valeurs_recu['facturation_pays'],
    ));
    
    $produits = $em->getRepository('PlateformeCatalogueBundle:Produit')->findArray(array_keys($session->get('panier')));
    
    return $this->render('PlateformeEcommerceBundle:Tunnel:validation.html.twig', array(
      'produits'              =>  $produits,
      'panier'                =>  $session->get('panier'),
      'mode_livraison'        =>  $session->get('mode_livraison'),
      'tarif_livraison'       =>  $session->get('tarif_livraison'),
      'tva_livraison'         =>  $session->get('tva_livraison'),
      'adresse_livraison'     =>  $session->get('adresse_livraison'),
      'adresse_facturation'   =>  $session->get('adresse_facturation'),
    ));
  }

}
