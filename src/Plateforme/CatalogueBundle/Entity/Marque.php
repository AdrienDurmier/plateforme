<?php

namespace Plateforme\CatalogueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Marque
 *
 * @ORM\Table(name="catalogue_marque")
 * @ORM\Entity(repositoryClass="Plateforme\CatalogueBundle\Repository\MarqueRepository")
 */
class Marque extends Page {

  /**
   * @var int
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

}
