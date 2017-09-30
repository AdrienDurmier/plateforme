<?php

namespace Plateforme\CoreBundle\Repository;

/**
 * FAQQuestionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FAQQuestionRepository extends \Doctrine\ORM\EntityRepository
{
  /**
   * Recherche les questions à publier
   */
  public function findAllPublished()
  {
    $qb = $this->createQueryBuilder('q');
    $qb
      ->where('q.published = 1')
    ;
    return $qb
      ->getQuery()
      ->getResult()
    ;
  }
}
