<?php

namespace Plateforme\CatalogueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="media_image_produit")
 * @ORM\Entity(repositoryClass="Plateforme\CatalogueBundle\Repository\MediaImageProduitRepository")
 */
class MediaImageProduit extends \Plateforme\CoreBundle\Entity\Media {

  /**
   * @var int
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  public function getUploadDir() {
    return 'uploads/img/produit';
  }

}
