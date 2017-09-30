<?php

namespace Plateforme\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pays
 *
 * @ORM\Table(name="pays")
 * @ORM\Entity(repositoryClass="Plateforme\CoreBundle\Repository\PaysRepository")
 */
class Pays
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
     * @ORM\Column(name="pays_code", type="string", length=5, nullable=true, unique=true)
     */
    private $paysCode;

    /**
     * @var string
     *
     * @ORM\Column(name="pays_name", type="string", length=255, nullable=true)
     */
    private $paysName;


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
     * Set paysCode
     *
     * @param string $paysCode
     *
     * @return Pays
     */
    public function setPaysCode($paysCode)
    {
        $this->paysCode = $paysCode;
    
        return $this;
    }

    /**
     * Get paysCode
     *
     * @return string
     */
    public function getPaysCode()
    {
        return $this->paysCode;
    }

    /**
     * Set paysName
     *
     * @param string $paysName
     *
     * @return Pays
     */
    public function setPaysName($paysName)
    {
        $this->paysName = $paysName;
    
        return $this;
    }

    /**
     * Get paysName
     *
     * @return string
     */
    public function getPaysName()
    {
        return $this->paysName;
    }
    
    public function __toString() {
      return $this->paysName;
    }
}

