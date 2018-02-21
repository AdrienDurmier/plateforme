<?php

namespace Plateforme\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Civilite
 *
 * @ORM\Table(name="core_civilite")
 * @ORM\Entity(repositoryClass="Plateforme\CoreBundle\Repository\CiviliteRepository")
 */
class Civilite
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
     * @ORM\Column(name="prefix_name", type="string", length=255)
     */
    private $prefixName;

    /**
     * @var string
     *
     * @ORM\Column(name="prefix_fullname", type="string", length=255)
     */
    private $prefixFullname;


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
     * Set prefixName
     *
     * @param string $prefixName
     *
     * @return Civilite
     */
    public function setPrefixName($prefixName)
    {
        $this->prefixName = $prefixName;
    
        return $this;
    }

    /**
     * Get prefixName
     *
     * @return string
     */
    public function getPrefixName()
    {
        return $this->prefixName;
    }

    /**
     * Set prefixFullname
     *
     * @param string $prefixFullname
     *
     * @return Civilite
     */
    public function setPrefixFullname($prefixFullname)
    {
        $this->prefixFullname = $prefixFullname;
    
        return $this;
    }

    /**
     * Get prefixFullname
     *
     * @return string
     */
    public function getPrefixFullname()
    {
        return $this->prefixFullname;
    }
    
    public function __toString() {
      return $this->prefixFullname;
    }
}

