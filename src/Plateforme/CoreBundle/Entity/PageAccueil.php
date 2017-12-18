<?php

namespace Plateforme\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * PageAccueil
 *
 * @ORM\Table(name="page_accueil")
 * @ORM\Entity(repositoryClass="Plateforme\CoreBundle\Repository\PageAccueilRepository")
 */
class PageAccueil extends Page
{
  public function __construct() {
    parent::__construct();
    $this->xml_sitemap_priority = '1.0';
  }
  
  /**
   * @var int
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;
  
  /**
   * @var string
   * 
   * @ORM\Column(name="repere", type="text")
   */
  private $repere = 'accueil';
  
  /**
   * Set repere
   *
   * @param string $repere
   *
   * @return PageAccueil
   */
  public function setRepere($repere)
  {
      $this->repere = $repere;
      return $this;
  }

  /**
   * Get repere
   *
   * @return string
   */
  public function getRepere()
  {
      return $this->repere;
  }
  
}

