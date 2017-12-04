<?php

namespace Plateforme\EcommerceBundle\Services;

class CommandeService {

  private $em;

  public function __construct(\Doctrine\ORM\EntityManager $entityManager) {
    $this->em = $entityManager;
  }

  /**
   * Mise à jour d'une commande à la fin d'un paiement
   */
  public function update($commande) {
    $em = $this->em;
    $lignes_commande = $em->getRepository('PlateformeEcommerceBundle:CommandeLigne')->findByCommande($commande->getId());
    // Mise à jour du stock
    foreach ($lignes_commande as $ligne) {
      $produit = $em->getRepository('PlateformeCatalogueBundle:Produit')->find($ligne->getProduit());
      $stock_actuel = $produit->getStock();
      $quantite_commande = $ligne->getQuantite();
      $produit->setStock($stock_actuel - $quantite_commande);
      $em->persist($ligne);
    }
    // TODO Création d'une notification
    
    
    $em->flush();
  }

}
