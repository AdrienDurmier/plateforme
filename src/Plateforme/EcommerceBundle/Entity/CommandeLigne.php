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
     * @var string
     *
     * @ORM\Column(name="reference", type="string")
     */
    private $reference;
    
    /**
     * @var string
     *
     * @ORM\Column(name="designation", type="string")
     */
    private $designation;
    
    /**
     * @var string
     *
     * @ORM\Column(name="prix_unitaire_ht", type="decimal", precision=10, scale=2)
     */
    private $prix_unitaire_ht;

    
    /**
     * @var string
     *
     * @ORM\Column(name="tva", type="string")
     */
    private $tva;
    
    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;
    
    /**
     * @var string
     *
     * @ORM\Column(name="prix_total_ht", type="decimal", precision=10, scale=2)
     */
    private $prix_total_ht;

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

    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return CommandeLigne
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set designation
     *
     * @param string $designation
     *
     * @return CommandeLigne
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * Get designation
     *
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Set prixUnitaireHt
     *
     * @param string $prixUnitaireHt
     *
     * @return CommandeLigne
     */
    public function setPrixUnitaireHt($prixUnitaireHt)
    {
        $this->prix_unitaire_ht = $prixUnitaireHt;

        return $this;
    }

    /**
     * Get prixUnitaireHt
     *
     * @return string
     */
    public function getPrixUnitaireHt()
    {
        return $this->prix_unitaire_ht;
    }

    /**
     * Set tva
     *
     * @param string $tva
     *
     * @return CommandeLigne
     */
    public function setTva($tva)
    {
        $this->tva = $tva;

        return $this;
    }

    /**
     * Get tva
     *
     * @return string
     */
    public function getTva()
    {
        return $this->tva;
    }

    /**
     * Set prixTotalHt
     *
     * @param string $prixTotalHt
     *
     * @return CommandeLigne
     */
    public function setPrixTotalHt($prixTotalHt)
    {
        $this->prix_total_ht = $prixTotalHt;

        return $this;
    }

    /**
     * Get prixTotalHt
     *
     * @return string
     */
    public function getPrixTotalHt()
    {
        return $this->prix_total_ht;
    }
}
