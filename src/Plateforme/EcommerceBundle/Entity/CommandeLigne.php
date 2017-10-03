<?php

namespace Plateforme\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommandeLigne
 *
 * @ORM\Table(name="commande_ligne")
 * @ORM\Entity(repositoryClass="Plateforme\EcommerceBundle\Repository\CommandeLigneRepository")
 */
class CommandeLigne
{
    
    /** 
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Plateforme\CatalogueBundle\Entity\Produit") 
     * @ORM\JoinColumn(nullable=false) 
     */
    protected $produit;
    
    
    /** 
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Plateforme\EcommerceBundle\Entity\Commande") 
     * @ORM\JoinColumn(nullable=false) 
     */
    protected $commande;
    
    
    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer", nullable=true)
     */
    private $quantite;


    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return CommandeLigne
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return integer
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set produit
     *
     * @param \Plateforme\CatalogueBundle\Entity\Produit $produit
     *
     * @return CommandeLigne
     */
    public function setProduit(\Plateforme\CatalogueBundle\Entity\Produit $produit)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return \Plateforme\CatalogueBundle\Entity\Produit
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * Set commande
     *
     * @param \Plateforme\EcommerceBundle\Entity\Commande $commande
     *
     * @return CommandeLigne
     */
    public function setCommande(\Plateforme\EcommerceBundle\Entity\Commande $commande)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return \Plateforme\EcommerceBundle\Entity\Commande
     */
    public function getCommande()
    {
        return $this->commande;
    }
}
