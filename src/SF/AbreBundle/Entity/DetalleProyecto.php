<?php

namespace SF\AbreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetalleProyecto
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SF\AbreBundle\Entity\DetalleProyectoRepository")
 */
class DetalleProyecto
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
     * @ORM\Column(name="orden", type="integer", nullable=true)
     */
    private $orden;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="monto", type="decimal", nullable=true)
     */
    private $monto;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="plazo_desde", type="datetime", nullable=true)
     */
    private $plazoDesde;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="plazo_hasta", type="datetime", nullable=true)
     */
    private $plazoHasta;

    /**
     * @ORM\ManyToOne(targetEntity="EstadoProyecto", cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(name="estadoproyecto_id", referencedColumnName="id")
     **/
    private $estado;

    /**
     * @ORM\ManyToOne(targetEntity="Proyecto", cascade={"all"}, fetch="EAGER")
     */
    private $proyecto;


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
     * @return DetalleProyecto
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
     * @return DetalleProyecto
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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return DetalleProyecto
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set monto
     *
     * @param string $monto
     * @return DetalleProyecto
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return string 
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * Set plazoDesde
     *
     * @param \DateTime $plazoDesde
     * @return DetalleProyecto
     */
    public function setPlazoDesde($plazoDesde)
    {
        $this->plazoDesde = $plazoDesde;

        return $this;
    }

    /**
     * Get plazoDesde
     *
     * @return \DateTime 
     */
    public function getPlazoDesde()
    {
        return $this->plazoDesde;
    }

    /**
     * Set plazoHasta
     *
     * @param \DateTime $plazoHasta
     * @return DetalleProyecto
     */
    public function setPlazoHasta($plazoHasta)
    {
        $this->plazoHasta = $plazoHasta;

        return $this;
    }

    /**
     * Get plazoHasta
     *
     * @return \DateTime 
     */
    public function getPlazoHasta()
    {
        return $this->plazoHasta;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return DetalleProyecto
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set estado
     *
     * @param \SF\AbreBundle\Entity\EstadoProyecto $estado
     * @return DetalleProyecto
     */
    public function setEstado(\SF\AbreBundle\Entity\EstadoProyecto $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \SF\AbreBundle\Entity\EstadoProyecto 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set proyecto
     *
     * @param \SF\AbreBundle\Entity\Proyecto $proyecto
     * @return DetalleProyecto
     */
    public function setProyecto(\SF\AbreBundle\Entity\Proyecto $proyecto = null)
    {
        $this->proyecto = $proyecto;

        return $this;
    }

    /**
     * Get proyecto
     *
     * @return \SF\AbreBundle\Entity\Proyecto 
     */
    public function getProyecto()
    {
        return $this->proyecto;
    }
}
