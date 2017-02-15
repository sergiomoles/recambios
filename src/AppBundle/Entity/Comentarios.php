<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="comentarios")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ComentariosRepository")
 */
class Comentarios {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /** @ORM\Column(type="string", length=100) */
    protected $comentario;

    /** @ORM\Column(type="date", length=100) */
    protected $fecha;

    /** @ORM\Column(type="time", length=100) */
    protected $hora;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehiculo") */
    protected $vehiculoId;


    /**
     * (Add this method into your class)
     *
     * @return string String representation of this class
     */
    public function __toString()
    {
        return $this->comentario;
    }

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
     * Set comentario
     *
     * @param string $comentario
     * @return Comentarios
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Get comentario
     *
     * @return string 
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Comentarios
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
     * @return Comentarios
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
     * Set vehiculoId
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculoId
     * @return Comentarios
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
}
