<?php

namespace Plateforme\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * PageContact
 *
 * @ORM\Table(name="page_contact")
 * @ORM\Entity(repositoryClass="Plateforme\CoreBundle\Repository\PageContactRepository")
 */
class PageContact extends Page
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

