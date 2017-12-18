<?php

namespace Plateforme\CatalogueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Marque
 *
 * @ORM\Table(name="catalogue_marque")
 * @ORM\Entity(repositoryClass="Plateforme\CatalogueBundle\Repository\MarqueRepository")
 */
class Marque extends \Plateforme\CoreBundle\Entity\Page {

  /**
   * @var int
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @ORM\OneToOne(targetEntity="Plateforme\CatalogueBundle\Entity\MediaLogoMarque", cascade={"persist", "remove"})
   */
  private $logo;

  public function setLogo(\Plateforme\CatalogueBundle\Entity\MediaLogoMarque $logo = null) {
    $this->logo = $logo;
  }

  public function getLogo() {
    return $this->logo;
  }

}
