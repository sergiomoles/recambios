<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="historial")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\HistorialRepository")
 */
class Historial {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /** @ORM\Column(type="string", length=100) */
    protected $nombre;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoMovimiento") */
    protected $movimientoid;

    /** @ORM\Column(type="date", length=100) */
    protected $fecha;

    /** @ORM\Column(type="time", length=100) */
    protected $hora;


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
     * @return Historial
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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Historial
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
     * Set hora
     *
     * @param \DateTime $hora
     * @return Historial
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime 
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set movimientoid
     *
     * @param \AppBundle\Entity\TipoMovimiento $movimientoid
     * @return Historial
     */
    public function setMovimientoid(\AppBundle\Entity\TipoMovimiento $movimientoid = null)
    {
        $this->movimientoid = $movimientoid;

        return $this;
    }

    /**
     * Get movimientoid
     *
     * @return \AppBundle\Entity\TipoMovimiento 
     */
    public function getMovimientoid()
    {
        return $this->movimientoid;
    }

    /**
     * (Add this method into your class)
     *
     * @return string String representation of this class
     */
    public function __toString()
    {
        return $this->nombre;
    }
}
