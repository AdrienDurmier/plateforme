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
   * @ORM\OneToOne(targetEntity="Plateforme\CoreBundle\Entity\Page", cascade={"persist"})
   * @ORM\JoinColumn(nullable=true)
   */
  private $pageActive;

  /**
   * @var string
   *
   * @ORM\Column(name="slug", type="string", length=255, nullable=true)
   */
  private $slug;

  /**
   * @var string
   *
   * @ORM\Column(name="metatitle", type="string", length=255)
   */
  private $metatitle;

  /**
   * @var string
   *
   * @ORM\Column(name="metadescription", type="text")
   */
  private $metadescription;

  /**
   * @var string
   *
   * @ORM\Column(name="xml_sitemap_priority", type="decimal", precision=10, scale=1, nullable=true)
   */
  protected $xml_sitemap_priority;

  /**
   * @var string
   *
   * @ORM\Column(name="xml_sitemap_changefreq", type="string", length=255, nullable=true)
   */
  protected $xml_sitemap_changefreq;

  /**
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->id;
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

  /**
   * Set slug
   *
   * @param string $slug
   *
   * @return Page
   */
  public function setSlug($slug) {
    if (empty($slug)) {
      $this->slug = $this->slugify($this->metatitle);
    }
    else {
      $this->slug = $this->slugify($slug);
    }

    return $this;
  }

  /**
   * Get slug
   *
   * @return string
   */
  public function getSlug() {
    return $this->slug;
  }

  public function slugify($texte) {
    $texte = preg_replace('#[^\\pL\d]+#u', '-', $texte);
    $texte = trim($texte, '-');
    if (function_exists('iconv')) {
      $texte = iconv('utf-8', 'us-ascii//TRANSLIT', $texte);
    }
    $texte = strtolower($texte);
    $texte = preg_replace('#[^-\w]+#', '', $texte);
    return $texte;
  }

  /**
   * Set metatitle
   *
   * @param string $metatitle
   *
   * @return Page
   */
  public function setMetatitle($metatitle) {
    $this->metatitle = $metatitle;
    $this->setSlug($metatitle);
    return $this;
  }

  /**
   * Get metatitle
   *
   * @return string
   */
  public function getMetatitle() {
    return $this->metatitle;
  }

  /**
   * Set metadescription
   *
   * @param string $metadescription
   *
   * @return Page
   */
  public function setMetadescription($metadescription) {
    if (empty($metadescription)) {
      $this->metadescription = $this->titre;
    }
    else {
      $this->metadescription = $metadescription;
    }

    return $this;
  }

  /**
   * Get metadescription
   *
   * @return string
   */
  public function getMetadescription() {
    return $this->metadescription;
  }

  /**
   * Set xmlSitemapPriority
   *
   * @param string $xmlSitemapPriority
   *
   * @return Page
   */
  public function setXmlSitemapPriority($xmlSitemapPriority) {
    $this->xml_sitemap_priority = $xmlSitemapPriority;

    return $this;
  }

  /**
   * Get xmlSitemapPriority
   *
   * @return string
   */
  public function getXmlSitemapPriority() {
    return $this->xml_sitemap_priority;
  }

  /**
   * Set xmlSitemapChangefreq
   *
   * @param string $xmlSitemapChangefreq
   *
   * @return Page
   */
  public function setXmlSitemapChangefreq($xmlSitemapChangefreq) {
    $this->xml_sitemap_changefreq = $xmlSitemapChangefreq;

    return $this;
  }

  /**
   * Get xmlSitemapChangefreq
   *
   * @return string
   */
  public function getXmlSitemapChangefreq() {
    return $this->xml_sitemap_changefreq;
  }

  /**
   * Set pageActive
   *
   * @param \Plateforme\CoreBundle\Entity\Page $pageActive
   *
   * @return Groupe
   */
  public function setPageActive(\Plateforme\CoreBundle\Entity\Page $pageActive) {
    $this->pageActive = $pageActive;

    return $this;
  }

  /**
   * Get pageActive
   *
   * @return \Plateforme\CoreBundle\Entity\Page
   */
  public function getPageActive() {
    return $this->pageActive;
  }

}
