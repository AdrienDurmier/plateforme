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
class Client extends Personne {

  public function __construct() {
    parent::__construct();
    $this->addRole('ROLE_CLIENT');
  }

  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @var string
   * 
   * @ORM\Column(name="telephone", type="string", length=255, nullable=true)
   */
  protected $telephone;

  /**
   * @var string
   * 
   * @ORM\Column(name="fax", type="string", length=255, nullable=true)
   */
  protected $fax;

  /**
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set telephone
   *
   * @param string $telephone
   *
   * @return Client
   */
  public function setTelephone($telephone) {
    $this->telephone = $telephone;
    return $this;
  }

  /**
   * Get telephone
   *
   * @return string
   */
  public function getTelephone() {
    return $this->telephone;
  }

  /**
   * Set fax
   *
   * @param string $fax
   *
   * @return Client
   */
  public function setFax($fax) {
    $this->fax = $fax;
    return $this;
  }

  /**
   * Get fax
   *
   * @return string
   */
  public function getFax() {
    return $this->fax;
  }

}
