<?php

namespace SF\AbreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Proyecto
 *
 * @ORM\Table(indexes={@ORM\Index(name="busquedas_idx", columns={"nombre", "ejetrabajo_id", "localidad_id", "intervencion_id", "lineaaccion_id"})})
 * @ORM\Entity(repositoryClass="SF\AbreBundle\Entity\ProyectoRepository")
 */
class Proyecto
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
     * @var string
     *
     * @ORM\Column(name="observacion", type="text")
     */
    private $observacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity="EjeTrabajo")
     * @ORM\JoinColumn(name="ejetrabajo_id", referencedColumnName="id")
     **/
    private $eje_trabajo;

    /**
     * @ORM\ManyToOne(targetEntity="Localidad")
     * @ORM\JoinColumn(name="localidad_id", referencedColumnName="id")
     **/
    private $localidad;

    /**
     * @ORM\ManyToOne(targetEntity="Intervencion")
     * @ORM\JoinColumn(name="intervencion_id", referencedColumnName="id")
     **/
    private $intervencion;

    /**
     * @ORM\ManyToOne(targetEntity="LineaAccion")
     * @ORM\JoinColumn(name="lineaaccion_id", referencedColumnName="id")
     **/
    private $linea_accion;

    /**
     * @ORM\ManyToOne(targetEntity="DatoGeografico", cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(name="datogeografico_id", referencedColumnName="geo_id")
     **/
    private $dato_geografico;

    /**
     * @ORM\OneToMany(targetEntity="DetalleProyecto", mappedBy="proyecto", cascade={"persist", "remove", "merge"})
     */
    public $detalles;

    /**
     * @var string
     *
     * @ORM\Column(name="cuerpo_publico", type="text", nullable=true)
     */
    private $cuerpo_publico;

    /**
     * @var string
     *
     * @ORM\Column(name="bajada_publica", type="text", nullable=true)
     */
    private $bajada_publica;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo_publico", type="string", length=255, nullable=true)
     */
    private $titulo_publico;

    /**
     * @var string
     *
     * @ORM\Column(name="monto_publico", type="string", length=255, nullable=true)
     */
    private $monto_publico;

    /**
     * @var string
     *
     * @ORM\Column(name="enlace", type="string", length=255, nullable=true)
     */
    private $enlace;

    /**
    * @var boolean
    * @ORM\column(type="boolean", nullable=true)
    */
    private $publicar = false;

    /**
    * @var boolean
    * @ORM\column(type="boolean", nullable=true)
    */
    private $mostrar_monto = false;

    /**
    * @var boolean
    * @ORM\column(type="boolean", nullable=true)
    */
    private $leido = false;

    /**
    * @ORM\OneToOne(targetEntity="Imagen", cascade={"persist"})
    */
    private $imagen;

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
     * @return Proyecto
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
     * @return Proyecto
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
     * Set observacion
     *
     * @param string $observacion
     * @return Proyecto
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string 
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Proyecto
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
     * Set eje_trabajo
     *
     * @param \SF\AbreBundle\Entity\EjeTrabajo $ejeTrabajo
     * @return Proyecto
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

    /**
     * Set intervencion
     *
     * @param \SF\AbreBundle\Entity\Intervencion $intervencion
     * @return Proyecto
     */
    public function setIntervencion(\SF\AbreBundle\Entity\Intervencion $intervencion = null)
    {
        $this->intervencion = $intervencion;

        return $this;
    }

    /**
     * Get intervencion
     *
     * @return \SF\AbreBundle\Entity\Intervencion 
     */
    public function getIntervencion()
    {
        return $this->intervencion;
    }

    /**
     * Set linea_accion
     *
     * @param \SF\AbreBundle\Entity\LineaAccion $lineaAccion
     * @return Proyecto
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
     * Set dato_geografico
     *
     * @param \SF\AbreBundle\Entity\DatoGeografico $datoGeografico
     * @return Proyecto
     */
    public function setDatoGeografico(\SF\AbreBundle\Entity\DatoGeografico $datoGeografico = null)
    {
        $this->dato_geografico = $datoGeografico;

        return $this;
    }

    /**
     * Get dato_geografico
     *
     * @return \SF\AbreBundle\Entity\DatoGeografico 
     */
    public function getDatoGeografico()
    {
        return $this->dato_geografico;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->detalles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return Proyecto
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Add detalles
     *
     * @param \SF\AbreBundle\Entity\DetalleProyecto $detalles
     * @return Proyecto
     */
    public function addDetalle(\SF\AbreBundle\Entity\DetalleProyecto $detalles)
    {
        $this->detalles[] = $detalles;

        return $this;
    }

    /**
     * Remove detalles
     *
     * @param \SF\AbreBundle\Entity\DetalleProyecto $detalles
     */
    public function removeDetalle(\SF\AbreBundle\Entity\DetalleProyecto $detalles)
    {
        $this->detalles->removeElement($detalles);
    }

    /**
     * Get detalles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDetalles()
    {
        return $this->detalles;
    }

    /**
     * Set localidad
     *
     * @param \SF\AbreBundle\Entity\Localidad $localidad
     * @return Proyecto
     */
    public function setLocalidad(\SF\AbreBundle\Entity\Localidad $localidad = null)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return \SF\AbreBundle\Entity\Localidad 
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set cuerpo_publico
     *
     * @param string $cuerpoPublico
     * @return Proyecto
     */
    public function setCuerpoPublico($cuerpoPublico)
    {
        $this->cuerpo_publico = $cuerpoPublico;

        return $this;
    }

    /**
     * Get cuerpo_publico
     *
     * @return string 
     */
    public function getCuerpoPublico()
    {
        return $this->cuerpo_publico;
    }

    /**
     * Set bajada_publica
     *
     * @param string $bajadaPublica
     * @return Proyecto
     */
    public function setBajadaPublica($bajadaPublica)
    {
        $this->bajada_publica = $bajadaPublica;

        return $this;
    }

    /**
     * Get bajada_publica
     *
     * @return string 
     */
    public function getBajadaPublica()
    {
        return $this->bajada_publica;
    }

    /**
     * Set titulo_publico
     *
     * @param string $tituloPublico
     * @return Proyecto
     */
    public function setTituloPublico($tituloPublico)
    {
        $this->titulo_publico = $tituloPublico;

        return $this;
    }

    /**
     * Get titulo_publico
     *
     * @return string 
     */
    public function getTituloPublico()
    {
        return $this->titulo_publico;
    }

    /**
     * Set monto_publico
     *
     * @param string $montoPublico
     * @return Proyecto
     */
    public function setMontoPublico($montoPublico)
    {
        $this->monto_publico = $montoPublico;

        return $this;
    }

    /**
     * Get monto_publico
     *
     * @return string 
     */
    public function getMontoPublico()
    {
        return $this->monto_publico;
    }

    /**
     * Set enlace
     *
     * @param string $enlace
     * @return Proyecto
     */
    public function setEnlace($enlace)
    {
        $this->enlace = $enlace;

        return $this;
    }

    /**
     * Get enlace
     *
     * @return string 
     */
    public function getEnlace()
    {
        return $this->enlace;
    }

    /**
     * Set publicar
     *
     * @param boolean $publicar
     * @return Proyecto
     */
    public function setPublicar($publicar)
    {
        $this->publicar = $publicar;

        return $this;
    }

    /**
     * Get publicar
     *
     * @return boolean 
     */
    public function getPublicar()
    {
        return $this->publicar;
    }

    /**
     * Set mostrar_monto
     *
     * @param boolean $mostrarMonto
     * @return Proyecto
     */
    public function setMostrarMonto($mostrarMonto)
    {
        $this->mostrar_monto = $mostrarMonto;

        return $this;
    }

    /**
     * Get mostrar_monto
     *
     * @return boolean 
     */
    public function getMostrarMonto()
    {
        return $this->mostrar_monto;
    }

    /**
     * Set leido
     *
     * @param boolean $leido
     * @return Proyecto
     */
    public function setLeido($leido)
    {
        $this->leido = $leido;

        return $this;
    }

    /**
     * Get leido
     *
     * @return boolean 
     */
    public function getLeido()
    {
        return $this->leido;
    }

    /**
     * Set estado
     *
     * @param \SF\AbreBundle\Entity\EstadoProyecto $estado
     * @return Proyecto
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
     * Set imagen
     *
     * @param \SF\AbreBundle\Entity\Imagen $imagen
     * @return Proyecto
     */
    public function setImagen(\SF\AbreBundle\Entity\Imagen $imagen = null)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get imagen
     *
     * @return \SF\AbreBundle\Entity\Imagen 
     */
    public function getImagen()
    {
        return $this->imagen;
    }
}
