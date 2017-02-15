<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="proveedor")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ProveedorRepository")
 */
class Proveedor {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /** @ORM\Column(type="string", length=100) */
    protected $nombre;

    /** @ORM\Column(type="string", length=100) */
    protected $numproveedor;

    /** @ORM\Column(type="string", length=100) */
    protected $correo;

    /** @ORM\Column(type="string", length=100) */
    protected $telefono;


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
     * @return Proveedor
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
     * Set numproveedor
     *
     * @param string $numproveedor
     * @return Proveedor
     */
    public function setNumproveedor($numproveedor)
    {
        $this->numproveedor = $numproveedor;

        return $this;
    }

    /**
     * Get numproveedor
     *
     * @return string 
     */
    public function getNumproveedor()
    {
        return $this->numproveedor;
    }

    /**
     * Set correo
     *
     * @param string $correo
     * @return Proveedor
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string 
     */
    public function getCorreo()
    {
        return $this->correo;
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
     * Set telefono
     *
     * @param string $telefono
     * @return Proveedor
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }
}
