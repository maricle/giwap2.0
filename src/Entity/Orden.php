<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Repository\EstadotrabajoRepository;
/**
 * Orden
 *
 *  
 *
 * @ORM\Table(name="orden", indexes={@ORM\Index(name="fk_orden_persona1_idx", columns={"persona_id"}), @ORM\Index(name="fk_orden_estadotrabajo1_idx", columns={"estadotrabajo_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\OrdenRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Orden {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha", type="date", nullable=false, options={"default": "CURRENT_DATE"})
     */
    private $fecha;

    /**
     * @var int|null
     *
     * @ORM\Column(name="prioridad", type="integer", nullable=false, options={"default": 1})
     */
    private $prioridad;

    /**
     * @var \Estadotrabajo
     *
     * @ORM\ManyToOne(targetEntity="Estadotrabajo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estadotrabajo_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $estadotrabajo;

    /**
     * @var \Persona
     *
     * @ORM\ManyToOne(targetEntity="Persona", inversedBy="ordenes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="persona_id", referencedColumnName="id")
     * })
     */
    private $persona;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="float")
     */
    private $cantidad = 1;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $medida_trabajo;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $papel;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $color;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $precio;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $copias;

    /**
     * @ORM\Column(type="boolean")
     */
    private $baja = false;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $numeracion;

    /**
     * @ORM\Column(type="float")
     */
    private $entrega = 0;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $original;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $impresion;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $terminado;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $entregado;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $sucursal;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Puntodeventa", inversedBy="ordenes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $puntodeventa;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Pago", mappedBy="orden",  cascade={"persist", "remove"})
     */
    private $pagos;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $saldo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Caracteristicas", mappedBy="ordenes")
     */
    private $caracteristicas;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LineaOrden", mappedBy="orden", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $lineas;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime",options={"default": "CURRENT_TIMESTAMP"})
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tipodetrabajo", inversedBy="ordenes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tipodetrabajo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="ordens")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comentario", mappedBy="orden")
     */
    private $comentario;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $cuenta_corriente;

    public function __construct() {
        $this->caracteristicas = new ArrayCollection();
        $this->pagos = new ArrayCollection();
        $this->lineas = new ArrayCollection();
        $this->comentario = new ArrayCollection();

        $this->setFecha(new \DateTime('now'));
        $this->setPrioridad(1);
            
        # $this->security = $security;
        # $this->setUser($this->security->getUser());
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface {
        return $this->fecha;
    }

    public function setFecha(?\DateTimeInterface $fecha): self {
        $this->fecha = $fecha;

        return $this;
    }

    public function getPrioridad(): ?int {
        return $this->prioridad;
    }

    public function setPrioridad(?int $prioridad): self {
        $this->prioridad = $prioridad;

        return $this;
    }

    public function getEstadotrabajo(): ?Estadotrabajo {
        return $this->estadotrabajo;
    }

    public function setEstadotrabajo(?Estadotrabajo $estadotrabajo): self {
        $this->estadotrabajo = $estadotrabajo;

        return $this;
    }

    public function getPersona(): ?Persona {
        return $this->persona;
    }

    public function setPersona(?Persona $persona): self {
        $this->persona = $persona;

        return $this;
    }

    public function __toString() {
        return (string) $this->id;
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

    public function getCantidad(): ?float {
        return $this->cantidad;
    }

    public function setCantidad(float $cantidad): self {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getMedidaTrabajo(): ?string {
        return $this->medida_trabajo;
    }

    public function setMedidaTrabajo(string $medida_trabajo): self {
        $this->medida_trabajo = $medida_trabajo;

        return $this;
    }

    public function getPapel(): ?string {
        return $this->papel;
    }

    public function setPapel(?string $papel): self {
        $this->papel = $papel;

        return $this;
    }

    public function getColor(): ?string {
        return $this->color;
    }

    public function setColor(?string $color): self {
        $this->color = $color;

        return $this;
    }

    public function getPrecio(): ?float {
        return $this->precio;
    }

    public function setPrecio(?float $precio): self {
        $this->precio = $precio;

        return $this;
    }

    public function getCount() {

        return 40000;
    }

    public function getTerminadasCount() {

        return 386;
    }

    public function getClientesMasImportantes() {
        return ['LaFormed', 'Sosa', 'Perez'];
    }

    public function getCopias(): ?int {
        return $this->copias;
    }

    public function setCopias(?int $copias): self {
        $this->copias = $copias;

        return $this;
    }

    public function getBaja(): ?bool {
        return $this->baja;
    }

    public function setBaja(bool $baja): self {
        $this->baja = $baja;

        return $this;
    }

    public function getNumeracion(): ?string {
        return $this->numeracion;
    }

    public function setNumeracion(?string $numeracion): self {
        $this->numeracion = $numeracion;

        return $this;
    }

    public function getEntrega(): ?float {
        //     $this->updateSaldo();
        return $this->entrega;
    }

    public function setEntrega(float $entrega): self {
        $this->entrega = $entrega;

        return $this;
    }

    public function getOriginal(): ?\DateTimeInterface {
        return $this->original;
    }

    public function setOriginal(?\DateTimeInterface $original): self {
        $this->original = $original;

        return $this;
    }

    public function getImpresion(): ?\DateTimeInterface {
        return $this->impresion;
    }

    public function setImpresion(?\DateTimeInterface $impresion): self {
        $this->impresion = $impresion;

        return $this;
    }

    public function getTerminado(): ?\DateTimeInterface {
        return $this->terminado;
    }

    public function setTerminado(?\DateTimeInterface $terminado): self {
        $this->terminado = $terminado;

        return $this;
    }

    public function getEntregado(): ?\DateTimeInterface {
        return $this->entregado;
    }

    public function setEntregado(?\DateTimeInterface $entregado): self {
        $this->entregado = $entregado;


        return $this;
    }

    public function getSucursal(): ?string {
        return $this->sucursal;
    }

    public function setSucursal(string $sucursal): self {
        $this->sucursal = $sucursal;

        return $this;
    }

    public function getPuntodeventa(): ?puntodeventa {
        return $this->puntodeventa;
    }

    public function setPuntodeventa(?puntodeventa $puntodeventa): self {
        $this->puntodeventa = $puntodeventa;

        return $this;
    }

    public function getEstadotrabajocolor(): ?string {
        return $this->getEstadotrabajo()->getColor();
    }

    public function getSaldo(): ?float {

        return $this->saldo;
    }

    /**
     * @return Collection|Pago[]
     */
    public function getPagos(): Collection {
        return $this->pagos;
    }

    public function addPago(Pago $pago): self {
        if (!$this->pagos->contains($pago)) {
            $this->pagos[] = $pago;
            $pago->setOrden($this);
        }

        return $this;
    }

    public function removePago(Pago $pago): self {
        if ($this->pagos->contains($pago)) {
            $this->pagos->removeElement($pago);
            // set the owning side to null (unless already changed)
            if ($pago->getOrden() === $this) {
                $pago->setOrden(null);
            }
        }

        return $this;
    }

    public function setSaldo(?float $saldo): self {

        $this->saldo = $saldo;
        return $this;
    }

    public function updateSaldo() {
        // echo 'entra'; die;
        $saldo = $this->getPrecio() - $this->getEntrega();

        $pagos = $this->getPagos();
        //var_dump($pagos);die;
        foreach ($pagos as $p) {
            #var_dump($p->get);die;
            $saldo -= floatval($p->getValor());
        }
        
        $this->setSaldo($saldo);
        #echo $this->saldo ; die;
        return $this;
    }

    /**
     * @return Collection|caracteristicas[]
     */
    public function getCaracteristicas(): Collection {
        return $this->caracteristicas;
    }

    public function addCaracteristica(caracteristicas $caracteristica): self {
        if (!$this->caracteristicas->contains($caracteristica)) {
            $this->caracteristicas[] = $caracteristica;
            $caracteristica->setOrdenes($this);
        }

        return $this;
    }

    public function removeCaracteristica(caracteristicas $caracteristica): self {
        if ($this->caracteristicas->contains($caracteristica)) {
            $this->caracteristicas->removeElement($caracteristica);
            // set the owning side to null (unless already changed)
            if ($caracteristica->getOrdenes() === $this) {
                $caracteristica->setOrdenes(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LineaOrden[]
     */
    public function getLineas(): Collection {
        return $this->lineas;
    }

    public function addLinea(LineaOrden $linea): self {
        if (!$this->lineas->contains($linea)) {
            $this->lineas[] = $linea;
            $linea->setOrden($this);
        }

        return $this;
    }

    public function removeLinea(LineaOrden $linea): self {
        if ($this->lineas->contains($linea)) {
            $this->lineas->removeElement($linea);
            // set the owning side to null (unless already changed)
            if ($linea->getOrden() === $this) {
                $linea->setOrden(null);
            }
        }

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function updateOrdenPayment() {
        //echo 'entra aca';
        //  die;
//      //  busco el pago asociado y actualizo el registro del pago
        //   $em = $this->getManagerForClass(Ordem::class);
//       
//   //     $repository= $this->getDoctrine()->getRepository(Orden::class);
//        
        //    $orden =  $this->getOrden();
////        
        // $this->updateSaldo();
//        
        if (is_null($this->getCreatedAt()))
            $this->setCreatedAt(new \DateTime('now'));
        if (is_null($this->getFecha()))
            $this->setFecha(new \DateTime('now'));
        if (is_null($this->getPrioridad()))
            $this->setPrioridad(1);
        $this->updateSaldo();

        $this->setUpdatedAt(new \DateTime('now'));
    }

    public function getCreatedAt(): ?\DateTimeInterface {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getTipodetrabajo(): ?Tipodetrabajo {
        return $this->tipodetrabajo;
    }

    public function setTipodetrabajo(?Tipodetrabajo $tipodetrabajo): self {
        $this->tipodetrabajo = $tipodetrabajo;

        return $this;
    }

    public function getUser(): ?User {
        return $this->user;
    }

    public function setUser(?User $user): self {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Comentario[]
     */
    public function getComentario(): Collection {
        return $this->comentario;
    }

    public function addComentario(Comentario $comentario): self {
        if (!$this->comentario->contains($comentario)) {
            $this->comentario[] = $comentario;
            $comentario->setOrden($this);
        }

        return $this;
    }

    public function removeComentario(Comentario $comentario): self {
        if ($this->comentario->contains($comentario)) {
            $this->comentario->removeElement($comentario);
            // set the owning side to null (unless already changed)
            if ($comentario->getOrden() === $this) {
                $comentario->setOrden(null);
            }
        }

        return $this;
    }

    public function getCuentaCorriente(): ?bool {
        return $this->cuenta_corriente;
    }

    public function setCuentaCorriente(?bool $cuenta_corriente): self {
        $this->cuenta_corriente = $cuenta_corriente;

        return $this;
    }

    public function ActualizarEstado(Estadotrabajo $estado): ?self {
        $this->setEstadotrabajo($estado);

        switch ($this->getEstadotrabajo()->getId()):
            case 2:
                // el original esta listo y pendiente de impresion, esta fecha indica Original listo
                $this->setOriginal(new \DateTime("Now"));
                break;
            case 4:
                $this->setImpresion(new \DateTime("Now"));
                break;
            case 5:
                $this->setTerminado(new \DateTime("Now"));
                break;
            case 8:
                $this->setEntregado(new \DateTime("Now"));
                break;
            case 9:
                $this->setEntregado(new \DateTime("Now"));
                break;
        endswitch;

        return $this;
    }

    public function getTienedeuda(): ?bool {

        if ($this->getSaldo() > 0):
            return true;
        else:
            return false;

        endif;
    }

    public function getOriginalst(): ? string {
        if (!is_null($this->getOriginal())) {
            return $this->getOriginal()->format('d/m/Y');
        } else {
            return '';
        }
    }
     public function getImpresionst(): ? string {
        if (!is_null($this->getImpresion())) {
            return $this->getImpresion()->format('d/m/Y');
        } else {
            return '';
        }
    }
     public function getTerminadost(): ? string {
        if (!is_null($this->getTerminado())) {
            return $this->getTerminado()->format('d/m/Y');
        } else {
            return '';
        }
    }
    public function getEntregadost(): ? string {
        if (!is_null($this->getEntregado())) {
            return $this->getEntregado()->format('d/m/Y');
        } else {
            return '';
        }
    }
    
    
    

}
