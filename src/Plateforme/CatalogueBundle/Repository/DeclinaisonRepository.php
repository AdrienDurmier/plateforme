<?php

namespace Plateforme\CatalogueBundle\Repository;

/**
 * DeclinaisonRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DeclinaisonRepository extends \Doctrine\ORM\EntityRepository {

  /**
   * Recherche d'une declinaison à partir d'une combinaison
   */
  public function findOneByCombinaisons($valeurs_recu) {
    $qb = $this->createQueryBuilder('d')
        ->Select('d')
        ->Where('d.produit = :produit')
        ->setParameter('produit', $valeurs_recu['produit_id']);
    $declinaisons = $qb->getQuery()->getResult();
    
    $result = null;
    foreach($declinaisons as $declinaison){
      foreach($declinaison->getCombinaison() as $attribut){
        // Si la valeur de cette combinaison ne correspond pas au choix du client alors on le saute
        if (!in_array($attribut->getValeur(), $valeurs_recu)) {
          continue 2;
        }
      }
      $result = $declinaison;
    }
    
    return $result;
  }

}
