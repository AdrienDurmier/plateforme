<?php

namespace Plateforme\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Groupe
 *
 * @ORM\Table(name="core_groupe")
 * @ORM\Entity(repositoryClass="Plateforme\CoreBundle\Repository\GroupeRepository")
 */
class Groupe {

  public function __construct() {
    $this->pages = new ArrayCollection();
  }

  /**
   * @var int
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\OneToMany(targetEntity="Plateforme\CoreBundle\Entity\Page", mappedBy="groupe", cascade={"persist", "remove"})
   */
  private $pages;

  /**
   * @var string
   *
   * @ORM\Column(name="redacteurs", type="array", nullable=true)
   */
  private $redacteurs;

  /**
   * @var string
   *
   * @ORM\Column(name="correcteurs", type="array", nullable=true)
   */
  private $correcteurs;

  /**
   * @var string
   *
   * @ORM\Column(name="approbateurs", type="array", nullable=true)
   */
  private $approbateurs;

  /**
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set redacteurs
   *
   * @param array $redacteurs
   *
   * @return PagePages
   */
  public function setRedacteurs($redacteurs) {
    $this->redacteurs = $redacteurs;

    return $this;
  }

  /**
   * Get redacteurs
   *
   * @return array
   */
  public function getRedacteurs() {
    return $this->redacteurs;
  }

  /**
   * Set correcteurs
   *
   * @param array $correcteurs
   *
   * @return PagePages
   */
  public function setCorrecteurs($correcteurs) {
    $this->correcteurs = $correcteurs;

    return $this;
  }

  /**
   * Get correcteurs
   *
   * @return array
   */
  public function getCorrecteurs() {
    return $this->correcteurs;
  }

  /**
   * Set approbateurs
   *
   * @param array $approbateurs
   *
   * @return PagePages
   */
  public function setApprobateurs($approbateurs) {
    $this->approbateurs = $approbateurs;

    return $this;
  }

  /**
   * Get approbateurs
   *
   * @return array
   */
  public function getApprobateurs() {
    return $this->approbateurs;
  }

  /**
   * Add page
   *
   * @param \Plateforme\CoreBundle\Entity\Page $page
   *
   * @return Groupe
   */
  public function addPage(\Plateforme\CoreBundle\Entity\Page $page) {
    $page->setGroupe($this); 
    $this->pages[] = $page;

    return $this;
  }

  /**
   * Remove page
   *
   * @param \Plateforme\CoreBundle\Entity\Page $page
   */
  public function removePage(\Plateforme\CoreBundle\Entity\Page $page) {
    $this->pages->removeElement($page);
  }

  /**
   * Get pages
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getPages() {
    return $this->pages;
  }

}
