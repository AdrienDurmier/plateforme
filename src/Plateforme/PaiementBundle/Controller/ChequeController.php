<?php

namespace Plateforme\PaiementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ChequeController extends Controller {
  
  
  /**
   * Formulaire de paiement
   */
  public function formAction() {
    return $this->render('PlateformePaiementBundle:Cheque:form.html.twig', array(
    ));
  }

  /**
   * Page de retour pour les paiements par chèque
   */
  public function returnAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $valeurs_recu = $request->request->all();
    
    // Récupération des status
    $statut_a_livrer = $em->getRepository('PlateformeEcommerceBundle:Statut')->find(6);
    
    // Modification du statut de la commande
    $commande = $em->getRepository('PlateformeEcommerceBundle:Commande')->find($valeurs_recu['commande_id']);
    $commande->setStatut($statut_a_livrer);
    $em->persist($commande);
    $em->flush();
    
    $session = $request->getSession();
    $session->remove('panier');
    return $this->render('PlateformeEcommerceBundle:PaiementCheque:retour.html.twig');
  }
  
}
