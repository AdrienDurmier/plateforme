<?php

namespace Plateforme\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adresse
 *
 * @ORM\Table(name="adresse")
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
     * @ORM\ManyToOne(targetEntity="Plateforme\CoreBundle\Entity\Commune")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commune;

    /**
     * @var string
     *
     * @ORM\Column(name="addr_street", type="string", length=255, nullable=true)
     */
    private $addrStreet;

    /**
     * @var string
     *
     * @ORM\Column(name="addr_additional", type="string", length=255, nullable=true)
     */
    private $addrAdditional;


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
     * Set commune
     * @param \Plateforme\CoreBundle\Entity\Commune $commune
     * @return Adresse
     */
    public function setCommune(\Plateforme\CoreBundle\Entity\Commune $commune)
    {
      $this->commune = $commune;
      return $this;
    }

    /**
     * Get commune
     * @return string
     */
    public function getCommune()
    {
      return $this->commune;
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
    
    
}

