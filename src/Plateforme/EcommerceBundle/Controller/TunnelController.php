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
    $session = $request->getSession();
    // Si le panier n'existe pas alors on redirige vers la page panier
    if (!$session->has('panier')) {
      return $this->redirectToRoute('plateforme_ecommerce_tunnel_panier');
    }
    
    // Création de la variable pour la livraison
    if (!$session->has('choix_livraison')) {
      $session->set('choix_livraison', array());
    }
    $choix_livraison = $session->get('choix_livraison');
    
    
    $panier = $session->get('panier');
    die('test');
    return $this->render('PlateformeEcommerceBundle:Tunnel:validation.html.twig', array(
      'panier'  =>  $panier,
    ));
  }

}
