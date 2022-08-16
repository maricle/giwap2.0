<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Estadotrabajo
 *
 * @ORM\Table(name="estadotrabajo")
 * @ORM\Entity(repositoryClass="App\Repository\EstadotrabajoRepository")
 */
class Estadotrabajo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=45, nullable=false)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $color;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function __toString() {
        return (string) $this->descripcion;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }
    
   
}
