<?php

namespace Plateforme\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sexe
 *
 * @ORM\Table(name="page_version_commentaire")
 * @ORM\Entity(repositoryClass="Plateforme\CoreBundle\Repository\VersionCommentaireRepository")
 */
class VersionCommentaire {

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
   * @var \DateTime
   *
   * @ORM\Column(name="created", type="datetimetz")
   */
  private $created;

  /**
   * @ORM\OneToOne(targetEntity="Plateforme\UserBundle\Entity\User", cascade={"persist"})
   */
  private $user;

  /**
   * @ORM\ManyToOne(targetEntity="Plateforme\CoreBundle\Entity\Version", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
  private $version;

  /**
   * @var string
   *
   * @ORM\Column(name="contenu", type="text")
   */
  private $contenu;

  /**
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set created
   *
   * @param \DateTime $created
   *
   * @return VersionCommentaire
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
   * Set user
   *
   * @param \Plateforme\UserBundle\Entity\User $user
   *
   * @return VersionCommentaire
   */
  public function setUser(\Plateforme\UserBundle\Entity\User $user = null) {
    $this->user = $user;

    return $this;
  }

  /**
   * Get user
   *
   * @return \Plateforme\UserBundle\Entity\User
   */
  public function getUser() {
    return $this->user;
  }

  /**
   * Set version
   *
   * @param \Plateforme\CoreBundle\Entity\Version $version
   *
   * @return VersionCommentaire
   */
  public function setVersion(\Plateforme\CoreBundle\Entity\Version $version) {
    $this->version = $version;

    return $this;
  }

  /**
   * Get version
   *
   * @return \Plateforme\CoreBundle\Entity\Version
   */
  public function getVersion() {
    return $this->version;
  }


    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return VersionCommentaire
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }
}
