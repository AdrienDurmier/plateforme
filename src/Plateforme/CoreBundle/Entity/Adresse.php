<?php

namespace Plateforme\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adresse
 *
 * @ORM\Table(name="core_adresse")
 * @ORM\Entity(repositoryClass="Plateforme\CoreBundle\Repository\AdresseRepository")
 */
class Adresse
{
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="complement", type="string", length=255, nullable=true)
     */
    private $complement;

    
    /**
     * @var string
     *
     * @ORM\Column(name="code_postal", type="string", length=255)
     */
    private $code_postal;
    
    /**
     * @var string
     *
     * @ORM\Column(name="commune", type="string", length=255)
     */
    private $commune;
    
    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=2)
     */
    private $pays;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="livraison", type="boolean", nullable=true)
     */
    private $livraison;
    
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="facturation", type="boolean", nullable=true)
     */
    private $facturation;
    
    /**
     * @ORM\ManyToOne(targetEntity="Plateforme\UserBundle\Entity\Client")
     * @ORM\JoinColumn(nullable=true)
     */
    private $client;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Adresse
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    
        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }
    
    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    
        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set complement
     *
     * @param string $complement
     *
     * @return Adresse
     */
    public function setComplement($complement)
    {
        $this->complement = $complement;
    
        return $this;
    }

    /**
     * Get complement
     *
     * @return string
     */
    public function getComplement()
    {
        return $this->complement;
    }
    
    /**
     * Set code_postal
     *
     * @param string $code_postal
     *
     * @return Adresse
     */
    public function setCodePostal($code_postal)
    {
        $this->code_postal = $code_postal;
    
        return $this;
    }

    /**
     * Get $code_postal
     *
     * @return string
     */
    public function getCodePostal()
    {
        return $this->code_postal;
    }
    
    /**
     * Set commune
     *
     * @param string $commune
     *
     * @return Adresse
     */
    public function setCommune($commune)
    {
        $this->commune = $commune;
    
        return $this;
    }

    /**
     * Get commune
     *
     * @return string
     */
    public function getCommune()
    {
        return $this->commune;
    }
    
    /**
     * Set pays
     *
     * @param string $pays
     *
     * @return Adresse
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
    
        return $this;
    }

    /**
     * Get pays
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }
    
    /**
     * Set livraison
     *
     * @param boolean $livraison
     *
     * @return Adresse
     */
    public function setLivraison($livraison)
    {
        $this->livraison = $livraison;
        return $this;
    }
    /**
     * Get livraison
     *
     * @return boolean
     */
    public function getLivraison()
    {
        return $this->livraison;
    }
    /**
     * Set facturation
     *
     * @param boolean $facturation
     *
     * @return Adresse
     */
    public function setFacturation($facturation)
    {
        $this->facturation = $facturation;
        return $this;
    }
    /**
     * Get facturation
     *
     * @return boolean
     */
    public function getFacturation()
    {
        return $this->facturation;
    }
    
    public function setClient(\Plateforme\UserBundle\Entity\Client $client)
    {
      $this->client = $client;
      return $this;
    }

    public function getClient()
    {
      return $this->client;
    }
}
