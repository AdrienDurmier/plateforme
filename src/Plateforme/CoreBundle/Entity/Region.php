<?php

namespace Plateforme\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Region
 *
 * @ORM\Table(name="region")
 * @ORM\Entity(repositoryClass="Plateforme\CoreBundle\Repository\RegionRepository")
 */
class Region
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
     * @ORM\ManyToOne(targetEntity="Plateforme\CoreBundle\Entity\Pays")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="region_code", type="string", length=5, nullable=false)
     */
    private $regionCode;

    /**
     * @var string
     *
     * @ORM\Column(name="region_name", type="string", length=255, nullable=true)
     */
    private $regionName;


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
     * Set pays
     * @param \Plateforme\CoreBundle\Entity\Pays $pays
     * @return Region
     */
    public function setPays(\Plateforme\CoreBundle\Entity\Pays $pays)
    {
      $this->pays = $pays;
      return $this;
    }

    /**
     * Get pays
     * @return string
     */
    public function getPays()
    {
      return $this->pays;
    }

    /**
     * Set regionCode
     *
     * @param string $regionCode
     *
     * @return Region
     */
    public function setRegionCode($regionCode)
    {
        $this->regionCode = $regionCode;
    
        return $this;
    }

    /**
     * Get regionCode
     *
     * @return string
     */
    public function getRegionCode()
    {
        return $this->regionCode;
    }

    /**
     * Set regionName
     *
     * @param string $regionName
     *
     * @return Region
     */
    public function setRegionName($regionName)
    {
        $this->regionName = $regionName;
    
        return $this;
    }

    /**
     * Get regionName
     *
     * @return string
     */
    public function getRegionName()
    {
        return $this->regionName;
    }
    
    public function __toString() {
      return $this->regionName;
    }
}

