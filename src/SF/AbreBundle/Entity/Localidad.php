<?php

namespace SF\AbreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Localidad
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SF\AbreBundle\Entity\LocalidadRepository")
 */
class Localidad
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="comu", type="integer")
     */
    private $comu;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Localidad
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set comu
     *
     * @param integer $comu
     * @return Localidad
     */
    public function setComu($comu)
    {
        $this->comu = $comu;

        return $this;
    }

    /**
     * Get comu
     *
     * @return integer 
     */
    public function getComu()
    {
        return $this->comu;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return Localidad
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function __toString() {
        return $this->nombre;
    }

}
