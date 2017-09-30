<?php

namespace Plateforme\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sexe
 *
 * @ORM\Table(name="sexe")
 * @ORM\Entity(repositoryClass="Plateforme\CoreBundle\Repository\SexeRepository")
 */
class Sexe
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
     * @ORM\Column(name="sexe_name", type="string", length=255)
     */
    private $sexeName;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe_fullname", type="string", length=255)
     */
    private $sexeFullname;


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
     * Set sexeName
     *
     * @param string $sexeName
     *
     * @return Sexe
     */
    public function setSexeName($sexeName)
    {
        $this->sexeName = $sexeName;
    
        return $this;
    }

    /**
     * Get sexeName
     *
     * @return string
     */
    public function getSexeName()
    {
        return $this->sexeName;
    }

    /**
     * Set sexeFullname
     *
     * @param string $sexeFullname
     *
     * @return Sexe
     */
    public function setSexeFullname($sexeFullname)
    {
        $this->sexeFullname = $sexeFullname;
    
        return $this;
    }

    /**
     * Get sexeFullname
     *
     * @return string
     */
    public function getSexeFullname()
    {
        return $this->sexeFullname;
    }
    
    public function __toString() {
      return $this->sexeFullname;
    }
}

