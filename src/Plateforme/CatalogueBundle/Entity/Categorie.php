<?php

namespace Plateforme\CatalogueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="catalogue_categorie")
 * @ORM\Entity(repositoryClass="Plateforme\CatalogueBundle\Repository\CategorieRepository")
 */
class Categorie extends Page {

  /**
   * @var int
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

}
