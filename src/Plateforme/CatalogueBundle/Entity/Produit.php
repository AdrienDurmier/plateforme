<?php

namespace Plateforme\CatalogueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="catalogue_produit")
 * @ORM\Entity(repositoryClass="Plateforme\CatalogueBundle\Repository\ProduitRepository")
 */
class Produit extends \Plateforme\CoreBundle\Entity\Page {

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
   * @ORM\Column(name="poids", type="decimal", precision=10, scale=2)
   */
  private $poids;
  
  /**
   * @ORM\OneToOne(targetEntity="Plateforme\CoreBundle\Entity\Image", cascade={"persist", "remove"})
   */
  private $image;
  
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
  
  public function setImage(\Plateforme\CoreBundle\Entity\Image $image = null)
  {
    $this->image = $image;
  }
  
  public function getImage()
  {
    return $this->image;
  }
  
  /**
   * Set tva
   *
   * @param \Plateforme\EcommerceBundle\Entity\Tva $tva
   * @return Produits
   */
  public function setTva(\Plateforme\EcommerceBundle\Entity\Tva $tva)
  {
      $this->tva = $tva;
      return $this;
  }
  /**
   * Get tva
   *
   * @return \Plateforme\EcommerceBundle\Entity\Tva 
   */
  public function getTva()
  {
      return $this->tva;
  }

}
