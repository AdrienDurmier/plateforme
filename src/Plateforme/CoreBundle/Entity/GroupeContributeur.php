<?php

namespace Plateforme\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * GroupeContributeur
 *
 * @ORM\Table(name="groupe_contributeur")
 * @ORM\Entity(repositoryClass="Plateforme\CoreBundle\Repository\GroupeContributeurRepository")
 */
class GroupeContributeur {

  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @var boolean
   *
   * @ORM\Column(name="redacteur", type="boolean", nullable=true)
   */
  private $redacteur;

  /**
   * @var boolean
   *
   * @ORM\Column(name="verificateur", type="boolean", nullable=true)
   */
  private $verificateur;

  /**
   * @var boolean
   *
   * @ORM\Column(name="approbateur", type="boolean", nullable=true)
   */
  private $approbateur;

  /**
   * @ORM\ManyToOne(targetEntity="Plateforme\CoreBundle\Entity\Groupe")
   * @ORM\JoinColumn(nullable=false)
   */
  private $groupe;

  /**
   * @ORM\ManyToOne(targetEntity="Plateforme\UserBundle\Entity\Employe")
   * @ORM\JoinColumn(nullable=false)
   */
  private $contributeur;

  /**
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->id;
  }


    /**
     * Set redacteur
     *
     * @param boolean $redacteur
     *
     * @return GroupeContributeur
     */
    public function setRedacteur($redacteur)
    {
        $this->redacteur = $redacteur;

        return $this;
    }

    /**
     * Get redacteur
     *
     * @return boolean
     */
    public function getRedacteur()
    {
        return $this->redacteur;
    }

    /**
     * Set verificateur
     *
     * @param boolean $verificateur
     *
     * @return GroupeContributeur
     */
    public function setVerificateur($verificateur)
    {
        $this->verificateur = $verificateur;

        return $this;
    }

    /**
     * Get verificateur
     *
     * @return boolean
     */
    public function getVerificateur()
    {
        return $this->verificateur;
    }

    /**
     * Set approbateur
     *
     * @param boolean $approbateur
     *
     * @return GroupeContributeur
     */
    public function setApprobateur($approbateur)
    {
        $this->approbateur = $approbateur;

        return $this;
    }

    /**
     * Get approbateur
     *
     * @return boolean
     */
    public function getApprobateur()
    {
        return $this->approbateur;
    }

    /**
     * Set groupe
     *
     * @param \Plateforme\CoreBundle\Entity\Groupe $groupe
     *
     * @return GroupeContributeur
     */
    public function setGroupe(\Plateforme\CoreBundle\Entity\Groupe $groupe)
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * Get groupe
     *
     * @return \Plateforme\CoreBundle\Entity\Groupe
     */
    public function getGroupe()
    {
        return $this->groupe;
    }

    /**
     * Set contributeur
     *
     * @param \Plateforme\UserBundle\Entity\Employe $contributeur
     *
     * @return GroupeContributeur
     */
    public function setContributeur(\Plateforme\UserBundle\Entity\Employe $contributeur)
    {
        $this->contributeur = $contributeur;

        return $this;
    }

    /**
     * Get contributeur
     *
     * @return \Plateforme\UserBundle\Entity\Employe
     */
    public function getContributeur()
    {
        return $this->contributeur;
    }
}
