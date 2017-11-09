<?php
namespace Plateforme\EcommerceBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * TarifLaposteColissimo
 *
 * @ORM\Table(name="tarif_laposte_colissimo")
 * @ORM\Entity(repositoryClass="Plateforme\EcommerceBundle\Repository\TarifLaposteColissimoRepository")
 */
class TarifLaposteColissimo
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
     * @ORM\Column(name="pays", type="string", length=2, unique=true)
     */
    private $pays;
    /**
     * @var string
     *
     * @ORM\Column(name="tarif", type="decimal", precision=10, scale=2)
     */
    private $tarif;
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
     * Set pays
     *
     * @param string $pays
     *
     * @return TarifLaposteColissimo
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
        return $this;
    }
    /**
     * Get pays
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }
    /**
     * Set tarif
     *
     * @param string $tarif
     *
     * @return TarifLaposteColissimo
     */
    public function setTarif($tarif)
    {
        $this->tarif = $tarif;
        return $this;
    }
    /**
     * Get tarif
     *
     * @return string
     */
    public function getTarif()
    {
        return $this->tarif;
    }
}
