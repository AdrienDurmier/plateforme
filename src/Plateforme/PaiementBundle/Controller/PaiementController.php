<?php

namespace Plateforme\PaiementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class PaiementController extends Controller {

  public function redirectionAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $session = $request->getSession();
    $valeurs_recu = $request->request->all();
    
    // Passage à l'étape de validation en envoyant les données nécessaires en fonction du mode de paiement
    switch ($valeurs_recu['mode_paiement']) {

      // Paiement par chèque
      case "paiement_cheque":
        $response = $this->forward('PlateformePaiementBundle:Cheque:form', array(
        ));
        return $response;
        break;
      // Paiement par virement bancaire
      case "paiement_virement":
        $response = $this->forward('PlateformePaiementBundle:Virement:form', array(
        ));
        return $response;
        break;
      // Paiement par Paypal
      case "paiement_paypal":
        $response = $this->forward('PlateformePaiementBundle:Paypal:form', array(
        ));
        return $response;
        break;
    }
    
    $this->get('session')->getFlashBag()->add('warning', 'Aucun mode de paiement choisi.');
    return $this->redirectToRoute('plateforme_ecommerce_tunnel_validation');
    
  }

}
