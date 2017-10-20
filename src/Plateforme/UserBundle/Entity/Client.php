<?php

namespace Plateforme\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;

/**
 * Client
 *
 * @ORM\Table(name="user_client")
 * @ORM\Entity(repositoryClass="Plateforme\UserBundle\Repository\ClientRepository")
 * @UniqueEntity(fields = "username", targetClass = "Plateforme\UserBundle\Entity\User", message="fos_user.username.already_used")
 * @UniqueEntity(fields = "email", targetClass = "Plateforme\UserBundle\Entity\User", message="fos_user.email.already_used")
 */
class Client extends Personne
{
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
}

