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

}
