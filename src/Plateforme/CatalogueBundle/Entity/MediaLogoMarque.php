<?php

namespace Plateforme\CatalogueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="media_logo_marque")
 * @ORM\Entity(repositoryClass="Plateforme\CatalogueBundle\Repository\MediaLogoMarqueRepository")
 */
class MediaLogoMarque extends \Plateforme\CoreBundle\Entity\Media {

  /**
   * @var int
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  public function getUploadDir() {
    return 'uploads/img/marque';
  }

}
