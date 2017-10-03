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
     * @var string
     *
     * @ORM\Column(name="total_ttc", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $totalTtc;

    /**
     * @var string
     *
     * @ORM\Column(name="mode_paiement", type="string", length=255, nullable=true)
     */
    private $modePaiement;

    /**
     * @var bool
     *
     * @ORM\Column(name="envoi", type="boolean", nullable=true)
     */
    private $envoi;
    
    /**
     * @var string
     *
     * @ORM\Column(name="poids_kg", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $poidsKg;

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
     * Set totalTtc
     *
     * @param string $totalTtc
     *
     * @return Commande
     */
    public function setTotalTtc($totalTtc)
    {
        $this->totalTtc = $totalTtc;

        return $this;
    }

    /**
     * Get totalTtc
     *
     * @return string
     */
    public function getTotalTtc()
    {
        return $this->totalTtc;
    }

    /**
     * Set modePaiement
     *
     * @param string $modePaiement
     *
     * @return Commande
     */
    public function setModePaiement($modePaiement)
    {
        $this->modePaiement = $modePaiement;

        return $this;
    }

    /**
     * Get modePaiement
     *
     * @return string
     */
    public function getModePaiement()
    {
        return $this->modePaiement;
    }

    /**
     * Set envoi
     *
     * @param boolean $envoi
     *
     * @return Commande
     */
    public function setEnvoi($envoi)
    {
        $this->envoi = $envoi;

        return $this;
    }

    /**
     * Get envoi
     *
     * @return bool
     */
    public function getEnvoi()
    {
        return $this->envoi;
    }
    
    /**
     * Set poidsKg
     *
     * @param string $poidsKg
     *
     * @return Commande
     */
    public function setPoidsKg($poidsKg)
    {
        $this->poidsKg = $poidsKg;

        return $this;
    }

    /**
     * Get poidsKg
     *
     * @return string
     */
    public function getPoidsKg()
    {
        return $this->poidsKg;
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

