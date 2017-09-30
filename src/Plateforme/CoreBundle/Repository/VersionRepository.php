<?php

namespace Plateforme\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * VersionRepository
 */
class VersionRepository extends \Doctrine\ORM\EntityRepository
{
  
  /**
   * Recherche la version publiée
   * @param type $id -> identifiant de la page
   * @return type -> Page
   */
  public function findPublish($id)
  {
    $qb = $this->createQueryBuilder('version');
    $qb
      ->where('version.publish = 1')
      ->where('version.page = :id')
      ->setParameter('id', $id)
    ;
    return $qb
      ->getQuery()
      ->getResult()
    ;
  }
  
  /**
   * Permet de rechercher toutes les versions d'une page
   * @param type $id -> identifiant de la page
   * @return type -> Page
   */
  public function findAllByPage($id)
  {
    $qb = $this->createQueryBuilder('version');
    $qb
      ->where('version.page = :id')
      ->setParameter('id', $id)
    ;
    return $qb
      ->getQuery()
      ->getResult()
    ;
  }
  
}
