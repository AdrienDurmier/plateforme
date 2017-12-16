<?php

namespace Plateforme\CatalogueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="catalogue_categorie")
 * @ORM\Entity(repositoryClass="Plateforme\CatalogueBundle\Repository\CategorieRepository")
 */
class Categorie extends \Plateforme\CoreBundle\Entity\Page {

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

}
