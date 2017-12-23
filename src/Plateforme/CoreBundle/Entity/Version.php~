<?php

namespace Plateforme\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Version
 *
 * @ORM\Table(name="page_version")
 * @ORM\Entity(repositoryClass="Plateforme\CoreBundle\Repository\VersionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Version {

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
   * @var string
   *
   * @ORM\Column(name="idGroupe", type="string", length=255)
   */
  private $idGroupe;

  /**
   * @ORM\OneToOne(targetEntity="Plateforme\CoreBundle\Entity\Page", inversedBy="version")
   */
  private $page;

  /**
   * @var int
   *
   * @ORM\Column(name="numero", type="integer")
   */
  private $numero;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="created", type="datetimetz")
   */
  private $created;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="updated", type="datetimetz", nullable=true)
   */
  private $updated;

  /**
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set idGroupe
   *
   * @param string $idGroupe
   *
   * @return Version
   */
  public function setIdGroupe($idGroupe) {
    $this->idGroupe = $idGroupe;

    return $this;
  }

  /**
   * Get idGroupe
   *
   * @return string
   */
  public function getIdGroupe() {
    return $this->idGroupe;
  }

  /**
   * Set page
   *
   * @param \Plateforme\CoreBundle\Entity\Page $page
   *
   * @return Version
   */
  public function setPage(\Plateforme\CoreBundle\Entity\Page $page) {
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
   * Set numero
   *
   * @param integer $numero
   *
   * @return Version
   */
  public function setNumero($numero) {
    $this->numero = $numero;

    return $this;
  }

  /**
   * Get numero
   *
   * @return integer
   */
  public function getNumero() {
    return $this->numero;
  }

  /**
   * Set created
   *
   * @param \DateTime $created
   *
   * @return Version
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
   * Set updated
   *
   * @param \DateTime $updated
   *
   * @return Version
   */
  public function setUpdated($updated) {
    $this->updated = $updated;

    return $this;
  }

  /**
   * Get updated
   *
   * @return \DateTime
   */
  public function getUpdated() {
    return $this->updated;
  }

  /**
   * @ORM\PreUpdate
   */
  public function updateDate() {
    $this->setUpdated(new \Datetime());
  }

}
