<?php

namespace SF\AbreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EstadoProyecto
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SF\AbreBundle\Entity\EstadoProyectoRepository")
 */
class EstadoProyecto
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="pes_id", type="integer")
     */
    private $pes_id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;


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
     * @return EstadoProyecto
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
     * Set id
     *
     * @param integer $id
     * @return EstadoProyecto
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set pes_id
     *
     * @param integer $pesId
     * @return EstadoProyecto
     */
    public function setPesId($pesId)
    {
        $this->pes_id = $pesId;

        return $this;
    }

    /**
     * Get pes_id
     *
     * @return integer 
     */
    public function getPesId()
    {
        return $this->pes_id;
    }
}
