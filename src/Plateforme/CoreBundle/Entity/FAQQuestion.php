<?php

namespace Plateforme\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FAQQuestion
 *
 * @ORM\Table(name="faq_question")
 * @ORM\Entity(repositoryClass="Plateforme\CoreBundle\Repository\FAQQuestionRepository")
 */
class FAQQuestion
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
     * @ORM\ManyToOne(targetEntity="Plateforme\CoreBundle\Entity\PageFAQ")
     * @ORM\JoinColumn(nullable=false)
     */
    private $page_faq;
    
    /**
     * @ORM\ManyToOne(targetEntity="Plateforme\CoreBundle\Entity\FAQCategorie")
     * @ORM\JoinColumn(nullable=false)
     */
    private $faq_categorie;

    /**
     * @var string
     *
     * @ORM\Column(name="question", type="string", length=255)
     */
    private $question;

    /**
     * @var string
     *
     * @ORM\Column(name="reponse", type="text")
     */
    private $reponse;

    /**
     * @var int
     *
     * @ORM\Column(name="weight", type="integer", nullable=true)
     */
    private $weight;

    /**
     * @var bool
     *
     * @ORM\Column(name="published", type="boolean")
     */
    private $published;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function __toString() {
      return $this->question;
    }
    
    public function setPageFAQ(PageFAQ $page_faq)
    {
      $this->page_faq = $page_faq;

      return $this;
    }

    public function getPageFAQ()
    {
      return $this->page_faq;
    }
    
    public function setFAQCategorie(FAQCategorie $faq_categorie)
    {
      $this->faq_categorie = $faq_categorie;

      return $this;
    }

    public function getFAQCategorie()
    {
      return $this->faq_categorie;
    }

    /**
     * Set question
     *
     * @param string $question
     *
     * @return FAQQuestion
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set reponse
     *
     * @param string $reponse
     *
     * @return FAQQuestion
     */
    public function setReponse($reponse)
    {
        $this->reponse = $reponse;

        return $this;
    }

    /**
     * Get reponse
     *
     * @return string
     */
    public function getReponse()
    {
        return $this->reponse;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     *
     * @return FAQQuestion
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }
    
    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Message
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return bool
     */
    public function getPublished()
    {
        return $this->published;
    }
}

