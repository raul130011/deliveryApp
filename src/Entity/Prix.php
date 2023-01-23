<?php

namespace App\Entity;

use App\Repository\PrixRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrixRepository::class)]
class Prix
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $prixht = null;

    #[ORM\ManyToOne(inversedBy: 'prixes')]
    private ?Livreur $livreur = null;

    #[ORM\ManyToOne(inversedBy: 'prixes')]
    private ?Zoneliv $zone = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrixht(): ?float
    {
        return $this->prixht;
    }

    public function setPrixht(float $prixht): self
    {
        $this->prixht = $prixht;

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

    public function getZone(): ?Zoneliv
    {
        return $this->zone;
    }

    public function setZone(?Zoneliv $zone): self
    {
        $this->zone = $zone;

        return $this;
    }
}
