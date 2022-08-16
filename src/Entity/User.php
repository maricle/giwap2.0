<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Orden", mappedBy="user")
     */
    private $ordens;

    public function __construct() {
        parent::__construct();
        $this->ordens = new ArrayCollection();
        // your own logic
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Orden[]
     */
    public function getOrdens(): Collection
    {
        return $this->ordens;
    }

    public function addOrden(Orden $orden): self
    {
        if (!$this->ordens->contains($orden)) {
            $this->ordens[] = $orden;
            $orden->setUser($this);
        }

        return $this;
    }

    public function removeOrden(Orden $orden): self
    {
        if ($this->ordens->contains($orden)) {
            $this->ordens->removeElement($orden);
            // set the owning side to null (unless already changed)
            if ($orden->getUser() === $this) {
                $orden->setUser(null);
            }
        }

        return $this;
    }

}
