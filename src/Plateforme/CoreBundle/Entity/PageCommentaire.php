<?php

namespace Plateforme\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PageCommentaire
 *
 * @ORM\Table(name="core_page_commentaire")
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
   * @ORM\ManyToOne(targetEntity="Plateforme\CoreBundle\Entity\Page")
   */
  private $page;

  /**
   * @ORM\ManyToOne(targetEntity="Plateforme\UserBundle\Entity\User")
   */
  private $user;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="created", type="datetimetz")
   */
  private $created;

  /**
   * @var string
   *
   * @ORM\Column(name="comment", type="string", length=255)
   */
  private $comment;

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
   * Set comment
   *
   * @param string $comment
   *
   * @return PageCommentaire
   */
  public function setComment($comment) {
    $this->comment = $comment;

    return $this;
  }

  /**
   * Get comment
   *
   * @return string
   */
  public function getComment() {
    return $this->comment;
  }

  /**
   * Set page
   *
   * @param \Plateforme\CoreBundle\Entity\Page $page
   *
   * @return PageCommentaire
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

}
