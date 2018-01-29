<?php

namespace Plateforme\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Page
 *
 * @ORM\Table(name="page")
 * @ORM\Entity(repositoryClass="Plateforme\CoreBundle\Repository\PageRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *  "page_accueil" = "PageAccueil", 
 *  "page_standard" = "PageStandard", 
 *  "page_contact" = "PageContact", 
 *  "page_faq" = "PageFAQ", 
 *  "page_actualite" = "PageActualite", 
 *  "produit" = "\Plateforme\CatalogueBundle\Entity\Produit",
 *  "categorie" = "\Plateforme\CatalogueBundle\Entity\Categorie",
 *  "marque" = "\Plateforme\CatalogueBundle\Entity\Marque"
 * })
 * @ORM\HasLifecycleCallbacks()
 */
abstract class Page {

  public function __construct() {
    $this->created = new \Datetime();
    $this->xml_sitemap_changefreq = 'always';
    $this->xml_sitemap_priority = '0.5';
  }

  public function __toString() {
    return $this->titre;
  }

  public function getType() {
    $type = explode('\\', get_class($this));
    return end($type);
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
   * @var string
   *
   * @ORM\Column(name="titre", type="string", length=255)
   */
  private $titre;

  /**
   * @var string
   *
   * @ORM\Column(name="contenu", type="text")
   */
  private $contenu;

  /**
   * @var string
   *
   * @ORM\Column(name="slug", type="string", length=255)
   */
  private $slug;

  /**
   * @var string
   *
   * @ORM\Column(name="commentaire_version", type="string", length=255, nullable=true)
   */
  private $commentaireVersion;

  /**
   * @var string
   *
   * @ORM\Column(name="metatitle", type="string", length=255, nullable=true)
   */
  private $metatitle;

  /**
   * @var string
   *
   * @ORM\Column(name="metadescription", type="string", length=255, nullable=true)
   */
  private $metadescription;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="created", type="datetimetz")
   */
  private $created;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="updated", type="datetimetz", nullable=true)
   */
  private $updated;

  /**
   * @var boolean
   *
   * @ORM\Column(name="is_public", type="boolean", nullable=true)
   */
  private $is_public;

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
   * @ORM\ManyToOne(targetEntity="Plateforme\UserBundle\Entity\User")
   */
  private $auteur;

  /**
   * @ORM\ManyToOne(targetEntity="Plateforme\CoreBundle\Entity\Groupe", inversedBy="page")
   */
  private $groupe;

  /**
   * @ORM\ManyToOne(targetEntity="Plateforme\CoreBundle\Entity\Page", cascade={"persist"})
   * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
   */
  private $pageParent;

  /**
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set titre
   *
   * @param string $titre
   *
   * @return Page
   */
  public function setTitre($titre) {
    $this->titre = $titre;
    $this->setSlug($this->titre);
    return $this;
  }

  /**
   * Get titre
   *
   * @return string
   */
  public function getTitre() {
    return $this->titre;
  }

  /**
   * Set contenu
   *
   * @param string $contenu
   *
   * @return Page
   */
  public function setContenu($contenu) {
    $this->contenu = $contenu;
    return $this;
  }

  /**
   * Get contenu
   *
   * @return string
   */
  public function getContenu() {
    return $this->contenu;
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
      $this->slug = $this->slugify($this->titre);
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
   * Set commentaireVersion
   *
   * @param string $commentaireVersion
   *
   * @return Page
   */
  public function setCommentaireVersion($commentaireVersion) {
    $this->commentaireVersion = $commentaireVersion;

    return $this;
  }

  /**
   * Get commentaireVersion
   *
   * @return string
   */
  public function getCommentaireVersion() {
    return $this->commentaireVersion;
  }

  /**
   * Set metatitle
   *
   * @param string $metatitle
   *
   * @return Page
   */
  public function setMetatitle($metatitle) {
    if (empty($metatitle)) {
      $this->metatitle = $this->titre;
    }
    else {
      $this->metatitle = $metatitle;
    }
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
   * Set created
   *
   * @param \DateTime $created
   *
   * @return Parcours
   */
  public function setCreated($created) {
    $this->created = $created;

    return $this;
  }

  /**
   * Get created
   *
   * @return \DateTime
   */
  public function getCreated() {
    return $this->created;
  }

  /**
   * Set updated
   *
   * @param \DateTime $updated
   *
   * @return Parcours
   */
  public function setUpdated(\Datetime $updated = null) {
    $this->updated = $updated;

    return $this;
  }

  /**
   * Get updated
   *
   * @return \DateTime
   */
  public function getUpdated() {
    return $this->updated;
  }

  /**
   * @ORM\PreUpdate
   */
  public function updateDate() {
    $this->setUpdated(new \Datetime());
  }

  /**
   * Set isPublic
   *
   * @param boolean $isPublic
   *
   * @return Page
   */
  public function setIsPublic($isPublic) {
    $this->is_public = $isPublic;

    return $this;
  }

  /**
   * Get isPublic
   *
   * @return boolean
   */
  public function getIsPublic() {
    return $this->is_public;
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
   * Set auteur
   *
   * @param \Plateforme\UserBundle\Entity\User $auteur
   *
   * @return Page
   */
  public function setAuteur(\Plateforme\UserBundle\Entity\User $auteur = null) {
    $this->auteur = $auteur;

    return $this;
  }

  /**
   * Get auteur
   *
   * @return \Plateforme\UserBundle\Entity\User
   */
  public function getAuteur() {
    return $this->auteur;
  }

  /**
   * Set groupe
   *
   * @param \Plateforme\CoreBundle\Entity\Groupe $groupe
   *
   * @return Page
   */
  public function setGroupe(\Plateforme\CoreBundle\Entity\Groupe $groupe = null) {
    $this->groupe = $groupe;

    return $this;
  }

  /**
   * Get groupe
   *
   * @return \Plateforme\CoreBundle\Entity\Groupe
   */
  public function getGroupe() {
    return $this->groupe;
  }

  /**
   * Set pageParent
   *
   * @param \Plateforme\CoreBundle\Entity\Page $pageParent
   *
   * @return Page
   */
  public function setPageParent(\Plateforme\CoreBundle\Entity\Page $pageParent = null) {
    $this->pageParent = $pageParent;

    return $this;
  }

  /**
   * Get pageParent
   *
   * @return \Plateforme\CoreBundle\Entity\Page
   */
  public function getPageParent() {
    return $this->pageParent;
  }

}
