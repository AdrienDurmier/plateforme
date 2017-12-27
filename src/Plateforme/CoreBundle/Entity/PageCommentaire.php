<?php

namespace Plateforme\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sexe
 *
 * @ORM\Table(name="page_commentaire")
 * @ORM\Entity(repositoryClass="Plateforme\CoreBundle\Repository\PageCommentaireRepository")
 */
class PageCommentaire {

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
   * @ORM\ManyToOne(targetEntity="Plateforme\CoreBundle\Entity\Page", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
  private $page;

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
   * @return PageCommentaire
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
   * @return PageCommentaire
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
   * Set page
   *
   * @param \Plateforme\CoreBundle\Entity\Page $page
   *
   * @return PageCommentaire
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
     * Set contenu
     *
     * @param string $contenu
     *
     * @return PageCommentaire
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
