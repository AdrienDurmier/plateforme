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
     * @ORM\Column(name="addr_street", type="string", length=255)
     */
    private $addrStreet;

    /**
     * @var string
     *
     * @ORM\Column(name="addr_additional", type="string", length=255, nullable=true)
     */
    private $addrAdditional;

    
    /**
     * @var string
     *
     * @ORM\Column(name="addr_cp", type="string", length=255)
     */
    private $code_postal;
    
    /**
     * @var string
     *
     * @ORM\Column(name="addr_commune", type="string", length=255)
     */
    private $commune;
    
    /**
     * @var string
     *
     * @ORM\Column(name="addr_pays", type="string", length=255)
     */
    private $pays;
    
    /**
     * @var string
     *
     * @ORM\Column(name="destinataire_nom", type="string", length=255)
     */
    private $destinataire_nom;
    
    /**
     * @var string
     *
     * @ORM\Column(name="destinataire_prenom", type="string", length=255)
     */
    private $destinataire_prenom;
    
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
     * Set addrStreet
     *
     * @param string $addrStreet
     *
     * @return Adresse
     */
    public function setAddrStreet($addrStreet)
    {
        $this->addrStreet = $addrStreet;
    
        return $this;
    }

    /**
     * Get addrStreet
     *
     * @return string
     */
    public function getAddrStreet()
    {
        return $this->addrStreet;
    }

    /**
     * Set addrAdditional
     *
     * @param string $addrAdditional
     *
     * @return Adresse
     */
    public function setAddrAdditional($addrAdditional)
    {
        $this->addrAdditional = $addrAdditional;
    
        return $this;
    }

    /**
     * Get addrAdditional
     *
     * @return string
     */
    public function getAddrAdditional()
    {
        return $this->addrAdditional;
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
    
    public function setClient(\Plateforme\UserBundle\Entity\Client $client)
    {
      $this->client = $client;
      return $this;
    }

    public function getClient()
    {
      return $this->client;
    }
    
    /**
     * Set destinataire_nom
     *
     * @param string $destinataire_nom
     *
     * @return Adresse
     */
    public function setDestinataireNom($destinataire_nom)
    {
        $this->destinataire_nom = $destinataire_nom;
    
        return $this;
    }

    /**
     * Get destinataire_nom
     *
     * @return string
     */
    public function getDestinataireNom()
    {
        return $this->destinataire_nom;
    }
    
    /**
     * Set destinataire_prenom
     *
     * @param string $destinataire_prenom
     *
     * @return Adresse
     */
    public function setDestinatairePrenom($destinataire_prenom)
    {
        $this->destinataire_prenom = $destinataire_prenom;
    
        return $this;
    }

    /**
     * Get destinataire_prenom
     *
     * @return string
     */
    public function getDestinatairePrenom()
    {
        return $this->destinataire_prenom;
    }
}
