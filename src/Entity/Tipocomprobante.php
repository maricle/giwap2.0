<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tipocomprobante
 *
 * @ORM\Table(name="tipocomprobante")
 * @ORM\Entity
 */
class Tipocomprobante {

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
     * @ORM\Column(name="nombre", type="string", length=45, nullable=false)
     */
    private $nombre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="string", length=100, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=45, nullable=false)
     */
    private $codigo;

    public function getId(): ?int {
        return $this->id;
    }

    public function getNombre(): ?string {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion(): ?string {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getCodigo(): ?string {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): self {
        $this->codigo = $codigo;

        return $this;
    }

    public function __toString() {
        return (string) $this->nombre;
    }

}
