<?php

namespace Plateforme\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tva
 *
 * @ORM\Table(name="ecommerce_tva")
 * @ORM\Entity(repositoryClass="Plateforme\EcommerceBundle\Repository\TvaRepository")
 */
class Tva
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

