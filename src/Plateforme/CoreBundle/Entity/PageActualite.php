<?php

namespace Plateforme\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * PageActualite
 *
 * @ORM\Table(name="page_actualite")
 * @ORM\Entity(repositoryClass="Plateforme\CoreBundle\Repository\PageActualiteRepository")
 */
class PageActualite extends Page
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

