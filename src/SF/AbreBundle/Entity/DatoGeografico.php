<?php
    
namespace SF\AbreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DatoGeografico
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SF\AbreBundle\Entity\DatoGeograficoRepository")
 */
class DatoGeografico
{

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="geo_id", type="integer")
     */
    private $geoId;

    /**
     * @var string
     *
     * @ORM\Column(name="geo_char", type="string", length=255)
     */
    private $geoChar;

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return DatoGeografico
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set geoId
     *
     * @param integer $geoId
     * @return DatoGeografico
     */
    public function setGeoId($geoId)
    {
        $this->geoId = $geoId;

        return $this;
    }

    /**
     * Get geoId
     *
     * @return integer 
     */
    public function getGeoId()
    {
        return $this->geoId;
    }

    /**
     * Set geoChar
     *
     * @param string $geoChar
     * @return DatoGeografico
     */
    public function setGeoChar($geoChar)
    {
        $this->geoChar = $geoChar;

        return $this;
    }

    /**
     * Get geoChar
     *
     * @return string 
     */
    public function getGeoChar()
    {
        return $this->geoChar;
    }

    public function __toString() {
        return $this->geoChar;
    }
}
