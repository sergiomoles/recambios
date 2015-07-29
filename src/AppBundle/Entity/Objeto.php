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
    protected $referencia-proveedor;

    /** @ORM\Column(type="string", length=100) */
      protected $referencia-fabrica;
}