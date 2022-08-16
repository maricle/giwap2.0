<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Comprobante
 *
 * @ORM\Table(name="comprobante", indexes={@ORM\Index(name="fk_comprobante_tipocomprobante1_idx", columns={"tipocomprobante_id"}), @ORM\Index(name="fk_comprobante_persona1_idx", columns={"persona_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\ComprobanteRepository")
 */
class Comprobante
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
     * @ORM\Column(name="puntodeventa", type="string", length=45, nullable=true)
     */
    private $puntodeventa;

    /**
     * @var int
     *
     * @ORM\Column(name="numero", type="integer", nullable=false)
     */
    private $numero;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date", nullable=false)
     */
    private $fecha;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_vencimiento", type="date", nullable=true)
     */
    private $fechaVencimiento;

    /**
     * @var string|null
     *
     * @ORM\Column(name="documento", type="string", length=11, nullable=true)
     */
    private $documento;

    /**
     * @var string|null
     *
     * @ORM\Column(name="codigo", type="string", length=100, nullable=true)
     */
    private $codigo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cae", type="string", length=45, nullable=true)
     */
    private $cae;

    /**
     * @var int|null
     *
     * @ORM\Column(name="tipo", type="integer", nullable=true)
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="total", type="decimal", precision=15, scale=4, nullable=false, options={"default"="0.0000"})
     */
    private $total = '0.0000';

    /**
     * @var string|null
     *
     * @ORM\Column(name="saldo", type="decimal", precision=15, scale=4, nullable=true, options={"default"="0.0000"})
     */
    private $saldo = '0.0000';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="enviado", type="boolean", nullable=true)
     */
    private $enviado;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="afip", type="boolean", nullable=true)
     */
    private $afip;

    /**
     * @var int|null
     *
     * @ORM\Column(name="estadopago", type="integer", nullable=true)
     */
    private $estadopago;

    /**
     * @var bool
     *
     * @ORM\Column(name="compra", type="boolean", nullable=false)
     */
    private $compra;

    /**
     * @var \Persona
     *
     * @ORM\ManyToOne(targetEntity="Persona")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="persona_id", referencedColumnName="id")
     * })
     */
    private $persona;

    /**
     * @var \Tipocomprobante
     *
     * @ORM\ManyToOne(targetEntity="Tipocomprobante")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipocomprobante_id", referencedColumnName="id")
     * })
     */
    private $tipocomprobante;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Items", mappedBy="comprobante", orphanRemoval=true)
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPuntodeventa(): ?string
    {
        return $this->puntodeventa;
    }

    public function setPuntodeventa(?string $puntodeventa): self
    {
        $this->puntodeventa = $puntodeventa;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getFechaVencimiento(): ?\DateTimeInterface
    {
        return $this->fechaVencimiento;
    }

    public function setFechaVencimiento(?\DateTimeInterface $fechaVencimiento): self
    {
        $this->fechaVencimiento = $fechaVencimiento;

        return $this;
    }

    public function getDocumento(): ?string
    {
        return $this->documento;
    }

    public function setDocumento(?string $documento): self
    {
        $this->documento = $documento;

        return $this;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(?string $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getCae(): ?string
    {
        return $this->cae;
    }

    public function setCae(?string $cae): self
    {
        $this->cae = $cae;

        return $this;
    }

    public function getTipo(): ?int
    {
        return $this->tipo;
    }

    public function setTipo(?int $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getSaldo(): ?string
    {
        return $this->saldo;
    }

    public function setSaldo(?string $saldo): self
    {
        $this->saldo = $saldo;

        return $this;
    }

    public function getEnviado(): ?bool
    {
        return $this->enviado;
    }

    public function setEnviado(?bool $enviado): self
    {
        $this->enviado = $enviado;

        return $this;
    }

    public function getAfip(): ?bool
    {
        return $this->afip;
    }

    public function setAfip(?bool $afip): self
    {
        $this->afip = $afip;

        return $this;
    }

    public function getEstadopago(): ?int
    {
        return $this->estadopago;
    }

    public function setEstadopago(?int $estadopago): self
    {
        $this->estadopago = $estadopago;

        return $this;
    }

    public function getCompra(): ?bool
    {
        return $this->compra;
    }

    public function setCompra(bool $compra): self
    {
        $this->compra = $compra;

        return $this;
    }

    public function getPersona(): ?Persona
    {
        return $this->persona;
    }

    public function setPersona(?Persona $persona): self
    {
        $this->persona = $persona;

        return $this;
    }

    public function getTipocomprobante(): ?Tipocomprobante
    {
        return $this->tipocomprobante;
    }

    public function setTipocomprobante(?Tipocomprobante $tipocomprobante): self
    {
        $this->tipocomprobante = $tipocomprobante;

        return $this;
    }

   public function __toString() {
        return (string) $this->tipo.$this->numero;
    }

   /**
    * @return Collection|Items[]
    */
   public function getItems(): Collection
   {
       return $this->items;
   }

   public function addItem(Items $item): self
   {
       if (!$this->items->contains($item)) {
           $this->items[] = $item;
           $item->setComprob($this);
       }

       return $this;
   }

   public function removeItem(Items $item): self
   {
       if ($this->items->contains($item)) {
           $this->items->removeElement($item);
           // set the owning side to null (unless already changed)
           if ($item->getComprob() === $this) {
               $item->setComprob(null);
           }
       }

       return $this;
   }
}
