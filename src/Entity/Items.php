<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Items
 *
 * @ORM\Table(name="items", indexes={@ORM\Index(name="fk_items_producto1_idx", columns={"producto_id"}), @ORM\Index(name="fk_items_orden1_idx", columns={"orden_id"}), @ORM\Index(name="fk_items_comprobante1_idx", columns={"comprobante_id"}), @ORM\Index(name="fk_items_alicuota1_idx", columns={"alicuota_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\ItemsRepository")
 */
class Items
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
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="string", length=100, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="precio", type="decimal", precision=15, scale=4, nullable=false, options={"default"="0.0000"})
     */
    private $precio = '0.0000';

    /**
     * @var string
     *
     * @ORM\Column(name="cantidad", type="decimal", precision=10, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $cantidad = '0.00';

    /**
     * @var \Alicuota
     *
     * @ORM\ManyToOne(targetEntity="Alicuota")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="alicuota_id", referencedColumnName="id")
     * })
     */
    private $alicuota;

  
    /**
     * @var \Orden
     *
     * @ORM\ManyToOne(targetEntity="Orden")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="orden_id", referencedColumnName="id")
     * })
     */
    private $orden;

    /**
     * @var \Producto
     *
     * @ORM\ManyToOne(targetEntity="Producto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="producto_id", referencedColumnName="id")
     * })
     */
    private $producto;

    /**
     * @var \Comprobante 
     * @ORM\ManyToOne(targetEntity="App\Entity\Comprobante", inversedBy="items")
     * @ORM\JoinColumn(name="comprobante_id", referencedColumnName="id")
     */
    private $comprobante;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getPrecio(): ?string
    {
        return $this->precio;
    }

    public function setPrecio(string $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getCantidad(): ?string
    {
        return $this->cantidad;
    }

    public function setCantidad(string $cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getAlicuota(): ?Alicuota
    {
        return $this->alicuota;
    }

    public function setAlicuota(?Alicuota $alicuota): self
    {
        $this->alicuota = $alicuota;

        return $this;
    }

    public function getOrden(): ?Orden
    {
        return $this->orden;
    }

    public function setOrden(?Orden $orden): self
    {
        $this->orden = $orden;

        return $this;
    }

    public function getProducto(): ?Producto
    {
        return $this->producto;
    }

    public function setProducto(?Producto $producto): self
    {
        $this->producto = $producto;

        return $this;
    }

    public function getComprobante(): ?Comprobante
    {
        return $this->comprob;
    }

    public function setComprobante(?Comprobante $comprob): self
    {
        $this->comprob = $comprob;

        return $this;
    }


}
