<?php

namespace Plateforme\PaiementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ChequeController extends Controller {

  /**
   * Formulaire de paiement
   */
  public function indexAction($commande, Request $request) {
    
    $em = $this->getDoctrine()->getManager();
    
    // Mise à jour de la commande
    $lignes_commande = $em->getRepository('PlateformeEcommerceBundle:CommandeLigne')->findByCommande($commande->getId());
    foreach($lignes_commande as $ligne){
      $produit = $em->getRepository('PlateformeCatalogueBundle:Produit')->find($ligne->getProduit());
      $stock_actuel = $produit->getStock();
      $quantite_commande = $ligne->getQuantite();
      $produit->setStock($stock_actuel - $quantite_commande);
      $em->persist($ligne);
    }
    $em->flush();
    
    // Création d'une notification
    
    
    // Récupération des données utiles pour le paiement par chèque
    $site_name = $em->getRepository('PlateformeCoreBundle:Variable')->findOneByCode('site_name');
    $adresse_voie = $em->getRepository('PlateformeCoreBundle:Variable')->findOneByCode('adresse_voie');
    $adresse_complement = $em->getRepository('PlateformeCoreBundle:Variable')->findOneByCode('adresse_complement');
    $adresse_code_postal = $em->getRepository('PlateformeCoreBundle:Variable')->findOneByCode('adresse_code_postal');
    $adresse_commune = $em->getRepository('PlateformeCoreBundle:Variable')->findOneByCode('adresse_commune');
    $adresse_pays = $em->getRepository('PlateformeCoreBundle:Variable')->findOneByCode('adresse_pays');
    
    return $this->render('PlateformePaiementBundle:Cheque:index.html.twig', array(
          'site_name'             => $site_name->getValue(),
          'adresse_voie'          => $adresse_voie->getValue(),
          'adresse_complement'    => $adresse_complement->getValue(),
          'adresse_code_postal'   => $adresse_code_postal->getValue(),
          'adresse_commune'       => $adresse_commune->getValue(),
          'adresse_pays'          => $adresse_pays->getValue(),
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
