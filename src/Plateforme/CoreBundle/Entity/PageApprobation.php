<?php

namespace Plateforme\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PageApprobation
 *
 * @ORM\Table(name="core_page_approbation")
 * @ORM\Entity(repositoryClass="Plateforme\CoreBundle\Repository\PageApprobationRepository")
 */
class PageApprobation {

  public function __construct() {
    $this->created = new \Datetime();
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
   * @ORM\ManyToOne(targetEntity="Plateforme\CoreBundle\Entity\Page")
   */
  private $page;

  /**
   * @ORM\ManyToOne(targetEntity="Plateforme\UserBundle\Entity\Employe")
   */
  private $contributeur;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="created", type="datetimetz")
   */
  private $created;

  /**
   * @var int
   *
   * @ORM\Column(name="etat", type="integer", nullable=true)
   */
  private $etat;

  /**
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set page
   *
   * @param \Plateforme\CoreBundle\Entity\Page $page
   *
   * @return PageApprobation
   */
  public function setPage(\Plateforme\CoreBundle\Entity\Page $page = null) {
    $this->page = $page;

    return $this;
  }

  /**
   * Get page
   *
   * @return \Plateforme\CoreBundle\Entity\Page
   */
  public function getPage() {
    return $this->page;
  }

  /**
   * Set created
   *
   * @param \DateTime $created
   *
   * @return PageApprobation
   */
  public function setCreated($created) {
    $this->created = $created;

    return $this;
  }

  /**
   * Get created
   *
   * @return \DateTime
   */
  public function getCreated() {
    return $this->created;
  }

  /**
   * Set contributeur
   *
   * @param \Plateforme\UserBundle\Entity\Employe $contributeur
   *
   * @return PageApprobation
   */
  public function setContributeur(\Plateforme\UserBundle\Entity\Employe $contributeur = null) {
    $this->contributeur = $contributeur;

    return $this;
  }

  /**
   * Get contributeur
   *
   * @return \Plateforme\UserBundle\Entity\Employe
   */
  public function getContributeur() {
    return $this->contributeur;
  }


    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return PageApprobation
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return integer
     */
    public function getEtat()
    {
        return $this->etat;
    }
}
