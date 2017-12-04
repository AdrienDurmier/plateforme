<?php

namespace Plateforme\PaiementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class VirementController extends Controller {

  /**
   * Formulaire de paiement
   */
  public function indexAction($commande, Request $request) {
    $em = $this->getDoctrine()->getManager();

    // Mise à jour de la commande à partir du service
    $service_maj_commande = $this->container->get('ecommerce_commande');
    $service_maj_commande->update($commande);

    // URL du module de paiement
    $virement_iban = $this->container->getParameter('virement_iban');
    $virement_bic = $this->container->getParameter('virement_bic');

    return $this->render('PlateformePaiementBundle:Virement:index.html.twig', array(
          'virement_iban' => $virement_iban,
          'virement_bic' => $virement_bic,
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
