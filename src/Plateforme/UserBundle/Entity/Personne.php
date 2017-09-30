<?php

namespace Plateforme\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;

/**
 * Personne
 *
 * @ORM\Table(name="user_personne")
 * @ORM\Entity(repositoryClass="Plateforme\UserBundle\Repository\PersonneRepository")
 * @UniqueEntity(fields = "username", targetClass = "Plateforme\UserBundle\Entity\User", message="fos_user.username.already_used")
 * @UniqueEntity(fields = "email", targetClass = "Plateforme\UserBundle\Entity\User", message="fos_user.email.already_used")
 */
class Personne extends User
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Plateforme\CoreBundle\Entity\Sexe")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sexe;
    
    /**
     * @ORM\ManyToOne(targetEntity="Plateforme\CoreBundle\Entity\Civilite")
     * @ORM\JoinColumn(nullable=false)
     */
    private $civilite;

    /**
     * @var string
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * Get id
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set civilite
     * @param \Plateforme\CoreBundle\Entity\Civilite $civilite
     * @return Personne
     */
    public function setCivilite(\Plateforme\CoreBundle\Entity\Civilite $civilite)
    {
      $this->civilite = $civilite;
      return $this;
    }

    /**
     * Get civilite
     * @return string
     */
    public function getCivilite()
    {
      return $this->civilite;
    }
    
    /**
     * Set sexe
     * @param \Plateforme\CoreBundle\Entity\Sexe $sexe
     * @return Personne
     */
    public function setSexe(\Plateforme\CoreBundle\Entity\Sexe $sexe)
    {
      $this->sexe = $sexe;
      return $this;
    }

    /**
     * Get sexe
     * @return string
     */
    public function getSexe()
    {
      return $this->sexe;
    }

    /**
     * Set nom
     * @param string $nom
     * @return Personne
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    
        return $this;
    }

    /**
     * Get nom
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     * @param string $prenom
     * @return Personne
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    
        return $this;
    }

    /**
     * Get prenom
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

}

