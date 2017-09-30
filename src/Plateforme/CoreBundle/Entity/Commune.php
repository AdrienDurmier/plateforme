<?php

namespace Plateforme\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commune
 *
 * @ORM\Table(name="commune")
 * @ORM\Entity(repositoryClass="Plateforme\CoreBundle\Repository\CommuneRepository")
 */
class Commune
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
     * @ORM\ManyToOne(targetEntity="Plateforme\CoreBundle\Entity\Region")
     * @ORM\JoinColumn(nullable=false)
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="addr_postal_code", type="string", length=10, nullable=true)
     */
    private $addrPostalCode;

    /**
     * @var string
     *
     * @ORM\Column(name="addr_city", type="string", length=255, nullable=true)
     */
    private $addrCity;


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
     * Set region
     * @param \Plateforme\CoreBundle\Entity\Region $region
     * @return Commune
     */
    public function setRegion(\Plateforme\CoreBundle\Entity\Region $region)
    {
      $this->region = $region;
      return $this;
    }

    /**
     * Get region
     * @return string
     */
    public function getRegion()
    {
      return $this->region;
    }

    /**
     * Set addrPostalCode
     *
     * @param string $addrPostalCode
     *
     * @return Commune
     */
    public function setAddrPostalCode($addrPostalCode)
    {
        $this->addrPostalCode = $addrPostalCode;
    
        return $this;
    }

    /**
     * Get addrPostalCode
     *
     * @return string
     */
    public function getAddrPostalCode()
    {
        return $this->addrPostalCode;
    }

    /**
     * Set addrCity
     *
     * @param string $addrCity
     *
     * @return Commune
     */
    public function setAddrCity($addrCity)
    {
        $this->addrCity = $addrCity;
    
        return $this;
    }

    /**
     * Get addrCity
     *
     * @return string
     */
    public function getAddrCity()
    {
        return $this->addrCity;
    }
    
    public function __toString() {
      return $this->addrPostalCode . ' - '. $this->addrCity;
    }
}

