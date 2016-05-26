<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="objeto")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ObjetoRepository")
 */
class Objeto {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /** @ORM\Column(type="string", length=100) */
    protected $nombre;

    /** @ORM\Column(type="string", length=100) */
    protected $refproveedor;

    /** @ORM\Column(type="string", length=100) */
    protected $reffabrica;

    /** @ORM\Column(type="string", length=100) */
    protected $descripcion;


    /** @ORM\Column(type="integer") */
    protected $preciosalida;

    /** @ORM\Column(type="integer") */
    protected $precioentrada;

    /** @ORM\Column(type="date", length=100) */
    protected $fechaalta;

    /** @ORM\Column(type="date", length=100) */
    protected $fechamodificacion;

    /** @ORM\Column(type="string", length=100) */
    protected $ubicacion;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Proveedor") */
    protected $proveedorid;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Marca") */
    protected $marcaid;

    /** @ORM\Column(type="integer") */
    protected $cantidad;

    /** @ORM\Column(type="boolean") */
    protected $fuerastock;

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
     * @return Objeto
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
     * Set refproveedor
     *
     * @param string $refproveedor
     * @return Objeto
     */
    public function setRefproveedor($refproveedor)
    {
        $this->refproveedor = $refproveedor;

        return $this;
    }

    /**
     * Get refproveedor
     *
     * @return string 
     */
    public function getRefproveedor()
    {
        return $this->refproveedor;
    }

    /**
     * Set reffabrica
     *
     * @param string $reffabrica
     * @return Objeto
     */
    public function setReffabrica($reffabrica)
    {
        $this->reffabrica = $reffabrica;

        return $this;
    }

    /**
     * Get reffabrica
     *
     * @return string 
     */
    public function getReffabrica()
    {
        return $this->reffabrica;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Objeto
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set preciosalida
     *
     * @param integer $preciosalida
     * @return Objeto
     */
    public function setPreciosalida($preciosalida)
    {
        $this->preciosalida = $preciosalida;

        return $this;
    }

    /**
     * Get preciosalida
     *
     * @return integer 
     */
    public function getPreciosalida()
    {
        return $this->preciosalida;
    }

    /**
     * Set precioentrada
     *
     * @param integer $precioentrada
     * @return Objeto
     */
    public function setPrecioentrada($precioentrada)
    {
        $this->precioentrada = $precioentrada;

        return $this;
    }

    /**
     * Get precioentrada
     *
     * @return integer 
     */
    public function getPrecioentrada()
    {
        return $this->precioentrada;
    }

    /**
     * Set fechaalta
     *
     * @param \DateTime $fechaalta
     * @return Objeto
     */
    public function setFechaalta($fechaalta)
    {
        $this->fechaalta = $fechaalta;

        return $this;
    }

    /**
     * Get fechaalta
     *
     * @return \DateTime 
     */
    public function getFechaalta()
    {
        return $this->fechaalta;
    }

    /**
     * Set fechamodificacion
     *
     * @param \DateTime $fechamodificacion
     * @return Objeto
     */
    public function setFechamodificacion($fechamodificacion)
    {
        $this->fechamodificacion = $fechamodificacion;

        return $this;
    }

    /**
     * Get fechamodificacion
     *
     * @return \DateTime 
     */
    public function getFechamodificacion()
    {
        return $this->fechamodificacion;
    }

    /**
     * Set ubicacion
     *
     * @param string $ubicacion
     * @return Objeto
     */
    public function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    /**
     * Get ubicacion
     *
     * @return string 
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     * @return Objeto
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set proveedorid
     *
     * @param \AppBundle\Entity\Proveedor $proveedorid
     * @return Objeto
     */
    public function setProveedorid(\AppBundle\Entity\Proveedor $proveedorid = null)
    {
        $this->proveedorid = $proveedorid;

        return $this;
    }

    /**
     * Get proveedorid
     *
     * @return \AppBundle\Entity\Proveedor 
     */
    public function getProveedorid()
    {
        return $this->proveedorid;
    }

    /**
     * Set marcaid
     *
     * @param \AppBundle\Entity\Marca $marcaid
     * @return Objeto
     */
    public function setMarcaid(\AppBundle\Entity\Marca $marcaid = null)
    {
        $this->marcaid = $marcaid;

        return $this;
    }

    /**
     * Get marcaid
     *
     * @return \AppBundle\Entity\Marca 
     */
    public function getMarcaid()
    {
        return $this->marcaid;
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

    /**
     * Set fuerastock
     *
     * @param boolean $fuerastock
     * @return Objeto
     */
    public function setFuerastock($fuerastock)
    {
        $this->fuerastock = $fuerastock;

        return $this;
    }

    /**
     * Get fuerastock
     *
     * @return boolean 
     */
    public function getFuerastock()
    {
        return $this->fuerastock;
    }
}
