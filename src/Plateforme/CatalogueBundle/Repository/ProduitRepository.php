<?php

namespace Plateforme\CatalogueBundle\Repository;

/**
 * ProduitRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProduitRepository extends \Doctrine\ORM\EntityRepository {

  public function findArray($array) {
    $qb = $this->createQueryBuilder('u')
        ->Select('u')
        ->Where('u.id IN (:array)')
        ->setParameter('array', $array);
    return $qb->getQuery()->getResult();
  }

  /*
   * Fonction pour rechercher à partir du titre ou d'une combinaison de mot
   */
  public function findLikeTitre($query, $limit) {
    $termes = explode("+", $query); // Séparer les termes pour en faire autant de critère de recherche
    $fields = array('p.id', 'p.titre', 'p.slug', 'img.filename');
    $qb = $this->createQueryBuilder('p');
    $qb->select($fields);
    $qb->innerJoin('p.image', 'img');
    $qb->where('1 = 1');
    $i = 0;
    foreach ($termes as $terme): // Recherche les produits ayant un titre contenant l'ensemble des termes
      $qb->andWhere(
          $qb->expr()->like('p.titre', ':term' . $i)
      );
      $qb->setParameter('term' . $i, '%' . $terme . '%');
      $i++;
    endforeach;
    if($limit){
      $qb->setMaxResults($limit);
    }
    return $qb->getQuery()->getResult();
  }

}
