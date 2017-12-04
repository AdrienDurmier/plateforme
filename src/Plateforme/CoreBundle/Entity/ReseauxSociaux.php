<?php

namespace Plateforme\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReseauxSociaux
 *
 * @ORM\Table(name="reseaux_sociaux")
 * @ORM\Entity(repositoryClass="Plateforme\CoreBundle\Repository\ReseauxSociauxRepository")
 */
class ReseauxSociaux
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
     * @ORM\Column(name="facebook", type="string", length=255, nullable=true, unique=true)
     */
    private $facebook;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter", type="string", length=255, nullable=true, unique=true)
     */
    private $twitter;

    /**
     * @var string
     *
     * @ORM\Column(name="google", type="string", length=255, nullable=true, unique=true)
     */
    private $google;

    /**
     * @var string
     *
     * @ORM\Column(name="youtube", type="string", length=255, nullable=true, unique=true)
     */
    private $youtube;

    /**
     * @var string
     *
     * @ORM\Column(name="viadeo", type="string", length=255, nullable=true, unique=true)
     */
    private $viadeo;

    /**
     * @var string
     *
     * @ORM\Column(name="linkedin", type="string", length=255, nullable=true, unique=true)
     */
    private $linkedin;

    /**
     * @var string
     *
     * @ORM\Column(name="pinterest", type="string", length=255, nullable=true, unique=true)
     */
    private $pinterest;

    /**
     * @var string
     *
     * @ORM\Column(name="flickr", type="string", length=255, nullable=true, unique=true)
     */
    private $flickr;

    /**
     * @var string
     *
     * @ORM\Column(name="instagram", type="string", length=255, nullable=true, unique=true)
     */
    private $instagram;

    /**
     * @var string
     *
     * @ORM\Column(name="reddit", type="string", length=255, nullable=true, unique=true)
     */
    private $reddit;


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
     * Set facebook
     *
     * @param string $facebook
     *
     * @return ReseauxSociaux
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     *
     * @return ReseauxSociaux
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set google
     *
     * @param string $google
     *
     * @return ReseauxSociaux
     */
    public function setGoogle($google)
    {
        $this->google = $google;

        return $this;
    }

    /**
     * Get google
     *
     * @return string
     */
    public function getGoogle()
    {
        return $this->google;
    }

    /**
     * Set youtube
     *
     * @param string $youtube
     *
     * @return ReseauxSociaux
     */
    public function setYoutube($youtube)
    {
        $this->youtube = $youtube;

        return $this;
    }

    /**
     * Get youtube
     *
     * @return string
     */
    public function getYoutube()
    {
        return $this->youtube;
    }

    /**
     * Set viadeo
     *
     * @param string $viadeo
     *
     * @return ReseauxSociaux
     */
    public function setViadeo($viadeo)
    {
        $this->viadeo = $viadeo;

        return $this;
    }

    /**
     * Get viadeo
     *
     * @return string
     */
    public function getViadeo()
    {
        return $this->viadeo;
    }

    /**
     * Set linkedin
     *
     * @param string $linkedin
     *
     * @return ReseauxSociaux
     */
    public function setLinkedin($linkedin)
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    /**
     * Get linkedin
     *
     * @return string
     */
    public function getLinkedin()
    {
        return $this->linkedin;
    }

    /**
     * Set pinterest
     *
     * @param string $pinterest
     *
     * @return ReseauxSociaux
     */
    public function setPinterest($pinterest)
    {
        $this->pinterest = $pinterest;

        return $this;
    }

    /**
     * Get pinterest
     *
     * @return string
     */
    public function getPinterest()
    {
        return $this->pinterest;
    }

    /**
     * Set flickr
     *
     * @param string $flickr
     *
     * @return ReseauxSociaux
     */
    public function setFlickr($flickr)
    {
        $this->flickr = $flickr;

        return $this;
    }

    /**
     * Get flickr
     *
     * @return string
     */
    public function getFlickr()
    {
        return $this->flickr;
    }

    /**
     * Set instagram
     *
     * @param string $instagram
     *
     * @return ReseauxSociaux
     */
    public function setInstagram($instagram)
    {
        $this->instagram = $instagram;

        return $this;
    }

    /**
     * Get instagram
     *
     * @return string
     */
    public function getInstagram()
    {
        return $this->instagram;
    }

    /**
     * Set reddit
     *
     * @param string $reddit
     *
     * @return ReseauxSociaux
     */
    public function setReddit($reddit)
    {
        $this->reddit = $reddit;

        return $this;
    }

    /**
     * Get reddit
     *
     * @return string
     */
    public function getReddit()
    {
        return $this->reddit;
    }
}

