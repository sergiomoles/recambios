<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="historialvehiculo")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\HistorialVehiculoRepository")
 */
class HistorialVehiculo {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /** @ORM\Column(type="date", length=100) */
    protected $fecha;

    /** @ORM\Column(type="time", length=100) */
    protected $hora;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehiculo") */
    protected $vehiculoId;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Objeto") */
    protected $objetoId;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoMovimiento") */
    protected $movimientoid;


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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return HistorialVehiculo
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
     * @return HistorialVehiculo
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
     * (Add this method into your class)
     *
     * @return string String representation of this class
     */
    public function __toString()
    {
        return $this->id;
    }

    /**
     * Set vehiculoId
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculoId
     * @return HistorialVehiculo
     */
    public function setVehiculoId(\AppBundle\Entity\Vehiculo $vehiculoId = null)
    {
        $this->vehiculoId = $vehiculoId;

        return $this;
    }

    /**
     * Get vehiculoId
     *
     * @return \AppBundle\Entity\Vehiculo 
     */
    public function getVehiculoId()
    {
        return $this->vehiculoId;
    }

    /**
     * Set objetoId
     *
     * @param \AppBundle\Entity\Objeto $objetoId
     * @return HistorialVehiculo
     */
    public function setObjetoId(\AppBundle\Entity\Objeto $objetoId = null)
    {
        $this->objetoId = $objetoId;

        return $this;
    }

    /**
     * Get objetoId
     *
     * @return \AppBundle\Entity\Objeto 
     */
    public function getObjetoId()
    {
        return $this->objetoId;
    }

    /**
     * Set movimientoid
     *
     * @param \AppBundle\Entity\TipoMovimiento $movimientoid
     * @return HistorialVehiculo
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
}
