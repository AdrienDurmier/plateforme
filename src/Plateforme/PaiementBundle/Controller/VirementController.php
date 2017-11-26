<?php

namespace Plateforme\PaiementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class VirementController extends Controller {
  
  
  /**
   * Formulaire de paiement
   */
  public function formAction($commande, $lignes_commande, $tva_sur_livraison) {
    return $this->render('PlateformePaiementBundle:Virement:form.html.twig', array(
    ));
  }

  /**
   * Page de retour pour les paiements par virement bancaire
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
    return $this->render('PlateformeEcommerceBundle:PaiementVirement:retour.html.twig');
  }
  
}
