<?php

namespace Plateforme\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * PageFAQ
 *
 * @ORM\Table(name="page_faq")
 * @ORM\Entity(repositoryClass="Plateforme\CoreBundle\Repository\PageFAQRepository")
 */
class PageFAQ extends Page
{
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
  private $repere = 'faq';
  
  /**
   * Set repere
   *
   * @param string $repere
   *
   * @return PageFAQ
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

