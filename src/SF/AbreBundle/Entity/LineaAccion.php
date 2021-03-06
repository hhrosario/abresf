<?php

namespace SF\AbreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LineaAccion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SF\AbreBundle\Entity\LineaAccionRepository")
 */
class LineaAccion
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
     * @ORM\ManyToOne(targetEntity="EjeTrabajo")
     * @ORM\JoinColumn(name="ejetrabajo_id", referencedColumnName="id")
     **/
    private $eje_trabajo;

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
     * @return LineaAccion
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
     * @return LineaAccion
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
     * @return LineaAccion
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function __toString() {
        return $this->nombre;
    }


    /**
     * Set eje_trabajo
     *
     * @param \SF\AbreBundle\Entity\EjeTrabajo $ejeTrabajo
     * @return LineaAccion
     */
    public function setEjeTrabajo(\SF\AbreBundle\Entity\EjeTrabajo $ejeTrabajo = null)
    {
        $this->eje_trabajo = $ejeTrabajo;

        return $this;
    }

    /**
     * Get eje_trabajo
     *
     * @return \SF\AbreBundle\Entity\EjeTrabajo 
     */
    public function getEjeTrabajo()
    {
        return $this->eje_trabajo;
    }
}
