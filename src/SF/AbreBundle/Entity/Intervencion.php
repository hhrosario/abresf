<?php

namespace SF\AbreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Intervencion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SF\AbreBundle\Entity\IntervencionRepository")
 */
class Intervencion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="LineaAccion")
     * @ORM\JoinColumn(name="lineaaccion_id", referencedColumnName="id")
     **/
    private $linea_accion;

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
     * Set linea_accion
     *
     * @param \SF\AbreBundle\Entity\LineaAccion $lineaAccion
     * @return Intervencion
     */
    public function setLineaAccion(\SF\AbreBundle\Entity\LineaAccion $lineaAccion = null)
    {
        $this->linea_accion = $lineaAccion;

        return $this;
    }

    /**
     * Get linea_accion
     *
     * @return \SF\AbreBundle\Entity\LineaAccion 
     */
    public function getLineaAccion()
    {
        return $this->linea_accion;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Intervencion
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
     * @return Intervencion
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
     * @return Intervencion
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
