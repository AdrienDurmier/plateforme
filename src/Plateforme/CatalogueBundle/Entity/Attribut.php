<?php

namespace Plateforme\CatalogueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="catalogue_attribut")
 * @ORM\Entity(repositoryClass="Plateforme\CatalogueBundle\Repository\AttributRepository")
 */
class Attribut {

  public function __toString() {
    return $this->valeur;
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
   * @ORM\Column(name="valeur", type="string", length=255)
   */
  private $valeur;

  /**
   * @var string
   *
   * @ORM\Column(name="couleur", type="string", length=255, nullable=true)
   */
  private $couleur;

  /**
   * @ORM\ManyToOne(targetEntity="Plateforme\CatalogueBundle\Entity\AttributCategorie", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
  private $categorie;

  /**
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->id;
  }


    /**
     * Set valeur
     *
     * @param string $valeur
     *
     * @return Attribut
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;

        return $this;
    }

    /**
     * Get valeur
     *
     * @return string
     */
    public function getValeur()
    {
        return $this->valeur;
    }

    /**
     * Set couleur
     *
     * @param string $couleur
     *
     * @return Attribut
     */
    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * Get couleur
     *
     * @return string
     */
    public function getCouleur()
    {
        return $this->couleur;
    }

    /**
     * Set categorie
     *
     * @param \Plateforme\CatalogueBundle\Entity\AttributCategorie $categorie
     *
     * @return Attribut
     */
    public function setCategorie(\Plateforme\CatalogueBundle\Entity\AttributCategorie $categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \Plateforme\CatalogueBundle\Entity\AttributCategorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

}
