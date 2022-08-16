<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Persona
 *
 * @ORM\Table(name="persona", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_51E5B69BB6B12EC7", columns={"documento"})}, indexes={@ORM\Index(name="fk_Persona_condicion_iva_idx", columns={"condicion_iva_id"}), @ORM\Index(name="fk_Persona_tipo_documento1_idx", columns={"tipo_documento_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\PersonaRepository")
 */
class Persona
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
     * @ORM\Column(name="apellido", type="string", length=50, nullable=false)
     */
    private $apellido;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=45, nullable=true)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="direccion", type="string", length=150, nullable=true)
     */
    private $direccion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="telefono", type="string", length=45, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="documento", type="string", length=45, nullable=false)
     */
    private $documento;

    /**
     * @var bool
     *
     * @ORM\Column(name="habilitado", type="boolean", nullable=false, options={"default"="1"})
     */
    private $habilitado = '1';

    /**
     * @var bool
     *
     * @ORM\Column(name="gremio", type="boolean", nullable=false)
     */
    private $gremio;

    /**
     * @var bool
     *
     * @ORM\Column(name="proveedor", type="boolean", nullable=false)
     */
    private $proveedor;

    /**
     * @var \CondicionIva
     *
     * @ORM\ManyToOne(targetEntity="CondicionIva")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="condicion_iva_id", referencedColumnName="id")
     * })
     */
    private $condicionIva;

    /**
     * @var \TipoDocumento
     *
     * @ORM\ManyToOne(targetEntity="TipoDocumento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_documento_id", referencedColumnName="id")
     * })
     */
    private $tipoDocumento;
    
    
     /**
     * @ORM\OneToMany(targetEntity="App\Entity\Orden", mappedBy="persona")
     */
    private $ordenes;


    public function __construct() {
        $this->ordenes = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): self
    {
        $this->apellido = $apellido;

        return $this;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(?string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getDocumento(): ?string
    {
        return $this->documento;
    }

    public function setDocumento(string $documento): self
    {
        $this->documento = $documento;

        return $this;
    }

    public function getHabilitado(): ?bool
    {
        return $this->habilitado;
    }

    public function setHabilitado(bool $habilitado): self
    {
        $this->habilitado = $habilitado;

        return $this;
    }

    public function getGremio(): ?bool
    {
        return $this->gremio;
    }

    public function setGremio(bool $gremio): self
    {
        $this->gremio = $gremio;

        return $this;
    }

    public function getProveedor(): ?bool
    {
        return $this->proveedor;
    }

    public function setProveedor(bool $proveedor): self
    {
        $this->proveedor = $proveedor;

        return $this;
    }

    public function getCondicionIva(): ?CondicionIva
    {
        return $this->condicionIva;
    }

    public function setCondicionIva(?CondicionIva $condicionIva): self
    {
        $this->condicionIva = $condicionIva;

        return $this;
    }

    public function getTipoDocumento(): ?TipoDocumento
    {
        return $this->tipoDocumento;
    }

    public function setTipoDocumento(?TipoDocumento $tipoDocumento): self
    {
        $this->tipoDocumento = $tipoDocumento;

        return $this;
    }

    public function __toString() {
        return (string) $this->apellido.' '.$this->nombre;
    }
    
    public function getDeuda():?float{
         $ordenes = $this->getOrdenes();
         $saldo=0;
        foreach ($ordenes as $or) {
            $saldo +=$or->getSaldo();
        }
        return $saldo;
        
    }
     
    
/**
     * @return Collection|Orden[]
     */
    public function getOrdenes(): Collection
    { 
        return $this->ordenes;
    }
}
