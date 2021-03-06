<?php

namespace Plateforme\CatalogueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Categorie
 *
 * @ORM\Table(name="catalogue_categorie")
 * @ORM\Entity(repositoryClass="Plateforme\CatalogueBundle\Repository\CategorieRepository")
 */
class Categorie extends \Plateforme\CoreBundle\Entity\Page {

  public function __construct() {
    parent::__construct();
    $this->produits = new ArrayCollection();
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
   * @ORM\ManyToOne(targetEntity="Plateforme\CatalogueBundle\Entity\Categorie", cascade={"persist"})
   * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
   */
  private $categorie;

  /**
   * @ORM\ManyToMany(targetEntity="Plateforme\CatalogueBundle\Entity\Produit", mappedBy="categories")
   */
  private $produits;

  /**
   * Set categorie
   *
   * @param \Plateforme\CatalogueBundle\Entity\Categorie $categorie
   *
   * @return Categorie
   */
  public function setCategorie(\Plateforme\CatalogueBundle\Entity\Categorie $categorie = null) {
    $this->categorie = $categorie;

    return $this;
  }

  /**
   * Get categorie
   *
   * @return \Plateforme\CatalogueBundle\Entity\Categorie
   */
  public function getCategorie() {
    return $this->categorie;
  }


    /**
     * Add produit
     *
     * @param \Plateforme\CatalogueBundle\Entity\Produit $produit
     *
     * @return Categorie
     */
    public function addProduit(\Plateforme\CatalogueBundle\Entity\Produit $produit)
    {
        $this->produits[] = $produit;

        return $this;
    }

    /**
     * Remove produit
     *
     * @param \Plateforme\CatalogueBundle\Entity\Produit $produit
     */
    public function removeProduit(\Plateforme\CatalogueBundle\Entity\Produit $produit)
    {
        $this->produits->removeElement($produit);
    }

    /**
     * Get produits
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProduits()
    {
        return $this->produits;
    }
}
