<?php

namespace Plateforme\PaiementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Plateforme\EcommerceBundle\Entity\Commande;
use Plateforme\EcommerceBundle\Entity\CommandeLigne;

class PaiementController extends Controller {

  public function redirectionAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $session = $request->getSession();
    $valeurs_recu = $request->request->all();
    
    // print '<pre>';print_r($valeurs_recu);print '</pre>';die(); // DEBUG
    
    // Création de la commande
    $commande = new Commande();
    $commande->setTotalTtc(number_format($valeurs_recu['totalTTC'],2));
    $commande->setTotalHt(number_format($valeurs_recu['totalHT'],2));
    if(isset($valeurs_recu['totalTva'])){
      $commande->setTotalTva($valeurs_recu['totalTva']);
    }
    $commande->setTotalLivraison($valeurs_recu['totalLivraison']);
    $commande->setModeLivraison($session->get('mode_livraison'));
    $commande->setCoordonneesLivraison($session->get('adresse_livraison'));
    $commande->setCoordonneesFacturation($session->get('adresse_facturation'));
    $commande->setModePaiement($valeurs_recu['mode_paiement']);
    $commande->setUser($this->getUser());
    $etat_livraison_a_preparer = $em->getRepository('PlateformeEcommerceBundle:EtatLivraison')->findOneByCode('etat_livraison_a_preparer');
    $commande->setEtatLivraison($etat_livraison_a_preparer);
    $etat_paiement_attente = $em->getRepository('PlateformeEcommerceBundle:EtatPaiement')->findOneByCode('etat_paiement_attente');
    $commande->setEtatPaiement($etat_paiement_attente);
    $em->persist($commande);
    
    // Création des lignes de commande
    $panier = $session->get('panier');
    $produits = $em->getRepository('PlateformeCatalogueBundle:Produit')->findArray(array_keys($panier));
    foreach ($produits as $produit) {
      $ligne = new CommandeLigne();
      $ligne->setCommande($commande);
      $ligne->setProduit($produit);
      $ligne->setReference($produit->getId());
      $ligne->setDesignation($produit->getTitre());
      $ligne->setPrixUnitaireHt($produit->getPrix());
      $ligne->setTva($produit->getTva()->getNom());
      $ligne->setQuantite($panier[$produit->getId()]);
      $ligne->setPrixTotalHt($produit->getPrix() * $panier[$produit->getId()]);
      $em->persist($ligne);
    }
    $em->flush();
    
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
