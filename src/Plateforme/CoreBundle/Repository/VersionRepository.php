<?php

namespace Plateforme\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * VersionRepository
 */
class VersionRepository extends \Doctrine\ORM\EntityRepository {

  /**
   * Renvoie la dernière version d'une page
   */
  public function getLastVersion($id_groupe) {
    $qb = $this->createQueryBuilder('v');
    $qb->where('v.id_groupe = :id_groupe');
    $qb->orderBy('v.updated', 'DESC');
    $qb->setMaxResults(1);
    $qb->setParameter('id_groupe', $id_groupe);

    return $qb->getQuery()->getOneOrNullResult();
  }

}
