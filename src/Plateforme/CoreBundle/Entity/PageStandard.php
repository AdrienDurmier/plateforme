<?php

namespace Plateforme\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PageStandard
 *
 * @ORM\Table(name="page_standard")
 * @ORM\Entity(repositoryClass="Plateforme\CoreBundle\Repository\PageStandardRepository")
 */
class PageStandard extends Page
{
  /**
   * @var int
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;
  
}

