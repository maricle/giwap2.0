<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Pago
 *
 * @ORM\Table(name="pago", indexes={@ORM\Index(name="fk_pago_persona1_idx", columns={"persona_id"}), @ORM\Index(name="fk_pago_tipodepago1_idx", columns={"tipodepago_id"}), @ORM\Index(name="fk_pago_comprobante1_idx", columns={"comprobante_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\PagoRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Pago {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date", nullable=false)
     */
    private $fecha;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="string", length=45, nullable=true)
     */
    private $descripcion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="referencia", type="string", length=45, nullable=true)
     */
    private $referencia;

    /**
     * @var string
     *
     * @ORM\Column(name="valor", type="decimal", precision=15, scale=4, nullable=false)
     */
    private $valor;

    /**
     * @var \Comprobante
     *
     * @ORM\ManyToOne(targetEntity="Comprobante")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="comprobante_id", referencedColumnName="id")
     * })
     */
    private $comprobante;

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
     * @var \Tipodepago
     *
     * @ORM\ManyToOne(targetEntity="Tipodepago")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipodepago_id", referencedColumnName="id")
     * })
     */
    private $tipodepago;

    /**
     *  @var \Orden
     * 
     * @ORM\ManyToOne(targetEntity="Orden", inversedBy="pagos")
     * * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="orden_id", referencedColumnName="id")
     * })
     */
    private $orden;

    public function __toString() {
        return $this->getFecha()->format('d/m/Y') . '  | $' . $this->getValor();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self {
        $this->fecha = $fecha;

        return $this;
    }

    public function getDescripcion(): ?string {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getReferencia(): ?string {
        return $this->referencia;
    }

    public function setReferencia(?string $referencia): self {
        $this->referencia = $referencia;

        return $this;
    }

    public function getValor(): ?string {
        return $this->valor;
    }

    public function setValor(string $valor): self {
        $this->valor = $valor;

        return $this;
    }

    public function getComprobante(): ?Comprobante {
        return $this->comprobante;
    }

    public function setComprobante(?Comprobante $comprobante): self {
        $this->comprobante = $comprobante;

        return $this;
    }

    public function getPersona(): ?Persona {
        return $this->persona;
    }

    public function setPersona(?Persona $persona): self {
        $this->persona = $persona;

        return $this;
    }

    public function getTipodepago(): ?Tipodepago {
        return $this->tipodepago;
    }

    public function setTipodepago(?Tipodepago $tipodepago): self {
        $this->tipodepago = $tipodepago;

        return $this;
    }

    public function getOrden(): ?Orden {
        return $this->orden;
    }

    public function setOrden(?Orden $orden): self {
        $this->orden = $orden;

        return $this;
    }

    /**
     * @ORM\PostPersist
     */
    public function updateOrdenPayment() {
        //echo 'entra aca';
       // die;

//      busco el pago asociado y actualizo el registro del pago
    //   $em = $this->getManager(Ordem::class);
////       
     //   $repository = $this->getDoctrine()->getRepository(Orden::class);
//        
     //   $orden = $this->getOrden();
//////        
     //   $orden->actualizarSaldo();
////        
      //  $em->flush();
    }

}
