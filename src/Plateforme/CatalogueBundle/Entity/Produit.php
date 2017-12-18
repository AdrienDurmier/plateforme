<?php

namespace Plateforme\CatalogueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Produit
 *
 * @ORM\Table(name="catalogue_produit")
 * @ORM\Entity(repositoryClass="Plateforme\CatalogueBundle\Repository\ProduitRepository")
 */
class Produit extends \Plateforme\CoreBundle\Entity\Page {

  public function __construct() {
    parent::__construct();
    $this->categories = new ArrayCollection();
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
   * @ORM\Column(name="prix", type="decimal", precision=10, scale=2)
   */
  private $prix;

  /**
   * @var string
   *
   * @ORM\Column(name="poids", type="decimal", precision=10, scale=3, nullable=true)
   */
  private $poids;

  /**
   * @ORM\OneToOne(targetEntity="Plateforme\CatalogueBundle\Entity\MediaImageProduit", cascade={"persist", "remove"})
   */
  private $image;

  /**
   * @ORM\ManyToOne(targetEntity="Plateforme\CatalogueBundle\Entity\Marque", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
  private $marque;

  /**
   * @ORM\ManyToMany(targetEntity="Plateforme\CatalogueBundle\Entity\Categorie", inversedBy="produits")
   * @ORM\JoinTable(name="catalogue_produitcategorie")
   */
  private $categories;

  /**
   * @var int
   *
   * @ORM\Column(name="stock", type="integer", nullable=true)
   */
  private $stock;

  /**
   * @ORM\ManyToOne(targetEntity="Plateforme\EcommerceBundle\Entity\Tva", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
  private $tva;

  /**
   * Set prix
   *
   * @param string $prix
   *
   * @return Produit
   */
  public function setPrix($prix) {
    $this->prix = $prix;

    return $this;
  }

  /**
   * Get prix
   *
   * @return string
   */
  public function getPrix() {
    return $this->prix;
  }

  /**
   * Set poids
   *
   * @param string $poids
   *
   * @return Produit
   */
  public function setPoids($poids) {
    $this->poids = $poids;

    return $this;
  }

  /**
   * Get poids
   *
   * @return string
   */
  public function getPoids() {
    return $this->poids;
  }

  public function setImage(\Plateforme\CatalogueBundle\Entity\MediaImageProduit $image = null) {
    $this->image = $image;
  }

  public function getImage() {
    return $this->image;
  }

  /**
   * Set marque
   *
   * @param \Plateforme\CatalogueBundle\Entity\Marque $marque
   * @return Produits
   */
  public function setMarque(\Plateforme\CatalogueBundle\Entity\Marque $marque) {
    $this->marque = $marque;
    return $this;
  }

  /**
   * Get marque
   *
   * @return \Plateforme\CatalogueBundle\Entity\Marque 
   */
  public function getMarque() {
    return $this->marque;
  }

  /**
   * Set tva
   *
   * @param \Plateforme\EcommerceBundle\Entity\Tva $tva
   * @return Produits
   */
  public function setTva(\Plateforme\EcommerceBundle\Entity\Tva $tva) {
    $this->tva = $tva;
    return $this;
  }

  /**
   * Get tva
   *
   * @return \Plateforme\EcommerceBundle\Entity\Tva 
   */
  public function getTva() {
    return $this->tva;
  }

  /**
   * Set stock
   *
   * @param integer $stock
   *
   * @return Produit
   */
  public function setStock($stock) {
    $this->stock = $stock;

    return $this;
  }

  /**
   * Get stock
   *
   * @return integer
   */
  public function getStock() {
    return $this->stock;
  }


    /**
     * Add category
     *
     * @param \Plateforme\CatalogueBundle\Entity\Categorie $category
     *
     * @return Produit
     */
    public function addCategory(\Plateforme\CatalogueBundle\Entity\Categorie $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \Plateforme\CatalogueBundle\Entity\Categorie $category
     */
    public function removeCategory(\Plateforme\CatalogueBundle\Entity\Categorie $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
