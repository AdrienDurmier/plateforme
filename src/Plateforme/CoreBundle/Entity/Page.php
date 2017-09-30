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
 * @ORM\DiscriminatorMap({"page_accueil" = "PageAccueil", "page_contact" = "PageContact", "page_faq" = "PageFAQ", "page_actualite" = "PageActualite", "produit" = "\Plateforme\CatalogueBundle\Entity\Produit"})
 * @ORM\HasLifecycleCallbacks()
 */
abstract class Page
{
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function __construct()
    {
      $this->created = new \Datetime();
    }
    
    public function __toString() {
      return $this->titre;
    }
    
    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Page
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
        $this->setSlug($this->titre);
        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }
    
    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Page
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }
    
    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Page
     */
    public function setSlug($slug)
    {
        if (empty($slug)) {
          $this->slug = $this->slugify($this->titre);
        }else{
          $this->slug = $this->slugify($slug);
        }
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    public function slugify($texte)
    {
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Parcours
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Parcours
     */
    public function setUpdated(\Datetime $updated = null)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function updateDate()
    {
      $this->setUpdated(new \Datetime());
    }

}

