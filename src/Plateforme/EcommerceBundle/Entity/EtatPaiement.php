<?php

namespace Plateforme\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EtatPaiement
 *
 * @ORM\Table(name="etat_paiement")
 * @ORM\Entity(repositoryClass="Plateforme\EcommerceBundle\Repository\EtatPaiementRepository")
 */
class EtatPaiement {

  public function __toString() {
    return $this->label;
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
   * @ORM\Column(name="code", type="string", length=255, unique=true)
   */
  private $code;

  /**
   * @var string
   *
   * @ORM\Column(name="label", type="string", length=255, unique=true)
   */
  private $label;

  /**
   * @var string
   *
   * @ORM\Column(name="color", type="string", length=255, unique=false)
   */
  private $color;

  /**
   * Get id
   *
   * @return int
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set code
   *
   * @param string $code
   *
   * @return EtatPaiement
   */
  public function setCode($code) {
    $this->code = $code;

    return $this;
  }

  /**
   * Get code
   *
   * @return string
   */
  public function getCode() {
    return $this->code;
  }

  /**
   * Set label
   *
   * @param string $label
   *
   * @return EtatPaiement
   */
  public function setLabel($label) {
    $this->label = $label;

    return $this;
  }

  /**
   * Get label
   *
   * @return string
   */
  public function getLabel() {
    return $this->label;
  }

  /**
   * Set color
   *
   * @param string $color
   *
   * @return EtatLivraison
   */
  public function setColor($color) {
    $this->color = $color;

    return $this;
  }

  /**
   * Get color
   *
   * @return string
   */
  public function getColor() {
    return $this->color;
  }

}
