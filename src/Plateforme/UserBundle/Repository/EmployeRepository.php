<?php

namespace Plateforme\UserBundle\Repository;

/**
 * EmployeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EmployeRepository extends \Doctrine\ORM\EntityRepository {

  /**
   * Recherche d'un employé à partir d'un terme
   * @param type $query
   * @param type $limit
   * @return type
   */
  public function findLikeTerm($query, $limit = null) {
    $termes = explode("+", $query); // Séparer les termes pour en faire autant de critère de recherche
    $fields = array('u.id', 'u.nom', 'u.prenom', 'u.email');
    $qb = $this->createQueryBuilder('u');
    $qb->select($fields);
    $qb->where('1 = 1');
    $i = 0;
    foreach ($termes as $terme):
      $qb->Where('u.id = :terme' . $i);
      $qb->setParameter('terme' . $i, $terme);
      $qb->orWhere('u.nom LIKE :terme' . $i);
      $qb->setParameter('terme' . $i, '%' . $terme . '%');
      $qb->orWhere('u.prenom LIKE :terme' . $i);
      $qb->setParameter('terme' . $i, '%' . $terme . '%');
      $qb->orWhere('u.email LIKE :terme' . $i);
      $qb->setParameter('terme' . $i, '%' . $terme . '%');
      $i++;
    endforeach;
    
    $qb->orderBy('u.id', 'DESC');
    
    if ($limit) {
      $qb->setMaxResults($limit);
    }
    return $qb->getQuery()->getResult();
  }

}
