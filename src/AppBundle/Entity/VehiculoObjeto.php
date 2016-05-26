<?php
    namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
* @ORM\Table(name="vehiculoObjeto")
* @ORM\Entity(repositoryClass="AppBundle\Entity\VehiculoObjetoRepository")
*/
class VehiculoObjeto {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehiculo") */
    protected $vehiculoId;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Objeto") */
    protected $objetoId;

    /** @ORM\Column(type="date", length=100)
     * @ORM\GeneratedValue
     */
    protected $fechaEntrada;


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
     * Set vehiculoId
     *
     * @param \AppBundle\Entity\Vehiculo $vehiculoId
     * @return VehiculoObjeto
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
     * @return VehiculoObjeto
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
     * Set fechaEntrada
     *
     * @param \DateTime $fechaEntrada
     * @return VehiculoObjeto
     */
    public function setFechaEntrada($fechaEntrada)
    {
        $this->fechaEntrada = $fechaEntrada;

        return $this;
    }

    /**
     * Get fechaEntrada
     *
     * @return \DateTime 
     */
    public function getFechaEntrada()
    {
        return $this->fechaEntrada;
    }
}
