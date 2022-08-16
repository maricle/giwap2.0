<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LineaOrdenRepository")
 */
class LineaOrden
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\orden", inversedBy="lineas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orden;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Producto")
     * @ORM\JoinColumn(nullable=false)
     */
    private $producto;

    /**
     * @ORM\Column(type="integer")
     */
    private $cantidad;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=4)
     */
    private $precio;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrden(): ?orden
    {
        return $this->orden;
    }

    public function setOrden(?orden $orden): self
    {
        $this->orden = $orden;

        return $this;
    }

    public function getProducto(): ?producto
    {
        return $this->producto;
    }

    public function setProducto(?producto $producto): self
    {
        $this->producto = $producto;

        return $this;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getPrecio(): ?string
    {
        return $this->precio;
    }
     public function getPrecioTotal(): ?string
    {
        return $this->precio  *$this->getCantidad();
    }

    public function setPrecio(string $precio): self
    {
        $this->precio = $precio;

        return $this;
    }
    public function __toString() {
        return $this->cantidad.' '.$this->producto.' '.$this->precio;
    }
}
