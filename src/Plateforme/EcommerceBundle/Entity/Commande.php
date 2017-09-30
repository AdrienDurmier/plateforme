<?php

namespace Plateforme\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="ecommerce_commande")
 * @ORM\Entity(repositoryClass="Plateforme\EcommerceBundle\Repository\CommandeRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Commande
{
  
    public function __construct()
    {
      $this->created = new \Datetime();
    }
    
    public function __toString() {
      return $this->titre;
    }
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetimetz")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetimetz")
     */
    private $updated;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Parcours
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Parcours
     */
    public function setUpdated(\Datetime $updated = null)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function updateDate()
    {
      $this->setUpdated(new \Datetime());
    }
}

