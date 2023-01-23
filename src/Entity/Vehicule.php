<?php

namespace App\Entity;

use App\Repository\VehiculeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehiculeRepository::class)]
class Vehicule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $type = null;

    #[ORM\Column(length: 255)]
    private ?string $marque = null;

    #[ORM\Column(length: 255)]
    private ?string $immatriculation = null;

    #[ORM\Column(length: 255)]
    private ?string $numChassis = null;

    #[ORM\Column]
    private ?float $capVolume = null;

    #[ORM\Column]
    private ?float $capPoid = null;


    #[ORM\ManyToOne(inversedBy: 'etat')]
    private ?Livreur $livreur = null;

    #[ORM\Column]
    private ?int $etat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getNumChassis(): ?string
    {
        return $this->numChassis;
    }

    public function setNumChassis(string $numChassis): self
    {
        $this->numChassis = $numChassis;

        return $this;
    }

    public function getCapVolume(): ?float
    {
        return $this->capVolume;
    }

    public function setCapVolume(float $capVolume): self
    {
        $this->capVolume = $capVolume;

        return $this;
    }

    public function getCapPoid(): ?float
    {
        return $this->capPoid;
    }

    public function setCapPoid(float $capPoid): self
    {
        $this->capPoid = $capPoid;

        return $this;
    }

    public function getLivreur(): ?Livreur
    {
        return $this->livreur;
    }

    public function setLivreur(?Livreur $livreur): self
    {
        $this->livreur = $livreur;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
