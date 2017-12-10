<?php

namespace Plateforme\CatalogueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Declinaison
 *
 * @ORM\Table(name="catalogue_declinaison")
 * @ORM\Entity(repositoryClass="Plateforme\CatalogueBundle\Repository\DeclinaisonRepository")
 */
class Declinaison {

  public function __toString() {
    return $this->titre;
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
   * @ORM\Column(name="prix", type="decimal", precision=10, scale=2, nullable=true)
   */
  private $prix;

  /**
   * @var string
   *
   * @ORM\Column(name="poids", type="decimal", precision=10, scale=3, nullable=true)
   */
  private $poids;

  /**
   * @var int
   *
   * @ORM\Column(name="stock", type="integer", nullable=true, nullable=true)
   */
  private $stock;

  /**
   * @ORM\ManyToOne(targetEntity="Plateforme\EcommerceBundle\Entity\Tva", cascade={"persist"})
   * @ORM\JoinColumn(nullable=true)
   */
  private $tva;

  /**
   * @ORM\ManyToOne(targetEntity="Plateforme\CatalogueBundle\Entity\Produit", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
  private $produit;

  /**
   * @var string
   *
   * @ORM\Column(name="combinaison", type="array")
   */
  private $combinaison;

  /**
   * Set prix
   *
   * @param string $prix
   *
   * @return Declinaison
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
   * @return Declinaison
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

  public function setImage(\Plateforme\CoreBundle\Entity\Image $image = null) {
    $this->image = $image;
  }

  public function getImage() {
    return $this->image;
  }

  /**
   * Set stock
   *
   * @param integer $stock
   *
   * @return Declinaison
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
   * Set tva
   *
   * @param \Plateforme\EcommerceBundle\Entity\Tva $tva
   * @return Declinaisons
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
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set produit
   *
   * @param \Plateforme\CatalogueBundle\Entity\Produit $produit
   *
   * @return Declinaison
   */
  public function setProduit(\Plateforme\CatalogueBundle\Entity\Produit $produit) {
    $this->produit = $produit;

    return $this;
  }

  /**
   * Get produit
   *
   * @return \Plateforme\CatalogueBundle\Entity\Produit
   */
  public function getProduit() {
    return $this->produit;
  }


    /**
     * Set combinaison
     *
     * @param array $combinaison
     *
     * @return Declinaison
     */
    public function setCombinaison($combinaison)
    {
        $this->combinaison = $combinaison;

        return $this;
    }

    /**
     * Get combinaison
     *
     * @return array
     */
    public function getCombinaison()
    {
        return $this->combinaison;
    }
}
