<?php

namespace SF\AbreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EjeTrabajo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SF\AbreBundle\Entity\EjeTrabajoRepository")
 */
class EjeTrabajo
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
     * @ORM\Column(name="orden", type="integer")
     */
    private $orden;


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
     * @return EjeTrabajo
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
     * Set orden
     *
     * @param integer $orden
     * @return EjeTrabajo
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer 
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return EjeTrabajo
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
