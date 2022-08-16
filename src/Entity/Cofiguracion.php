<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cofiguracion
 *
 * @ORM\Table(name="cofiguracion")
 * @ORM\Entity(repositoryClass="App\Repository\ConfiguracionRepository")
 */
class Cofiguracion
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=20, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="valor", type="string", length=45, nullable=false)
     */
    private $valor;

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function getValor(): ?string
    {
        return $this->valor;
    }

    public function setValor(string $valor): self
    {
        $this->valor = $valor;

        return $this;
    }


}
