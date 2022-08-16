<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Producto
 *
 * @ORM\Table(name="producto", indexes={@ORM\Index(name="fk_producto_alicuota1_idx", columns={"alicuota_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\ProductoRepository")
 */
class Producto
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
     * @ORM\Column(name="nombre", type="string", length=45, nullable=false)
     */
    private $nombre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="string", length=200, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="precio", type="decimal", precision=15, scale=4, nullable=false, options={"default"="0.0000"})
     */
    private $precio = '0.0000';

    /**
     * @var string|null
     *
     * @ORM\Column(name="costo", type="decimal", precision=15, scale=4, nullable=true)
     */
    private $costo;

    /**
     * @var bool
     *
     * @ORM\Column(name="controlstock", type="boolean", nullable=false)
     */
    private $controlstock;

    /**
     * @var int
     *
     * @ORM\Column(name="stockinicial", type="integer", nullable=false)
     */
    private $stockinicial;

    /**
     * @var string|null
     *
     * @ORM\Column(name="listadeprecio", type="string", length=255, nullable=true)
     */
    private $listadeprecio;

    /**
     * @var \Alicuota
     *
     * @ORM\ManyToOne(targetEntity="Alicuota")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="alicuota_id", referencedColumnName="id")
     * })
     */
    private $alicuota;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
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

    public function getCosto(): ?string
    {
        return $this->costo;
    }

    public function setCosto(?string $costo): self
    {
        $this->costo = $costo;

        return $this;
    }

    public function getControlstock(): ?bool
    {
        return $this->controlstock;
    }

    public function setControlstock(bool $controlstock): self
    {
        $this->controlstock = $controlstock;

        return $this;
    }

    public function getStockinicial(): ?int
    {
        return $this->stockinicial;
    }

    public function setStockinicial(int $stockinicial): self
    {
        $this->stockinicial = $stockinicial;

        return $this;
    }

    public function getListadeprecio(): ?string
    {
        return $this->listadeprecio;
    }

    public function setListadeprecio(?string $listadeprecio): self
    {
        $this->listadeprecio = $listadeprecio;

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

    public function __toString() {
        return (string) $this->nombre;
    }

    
}
