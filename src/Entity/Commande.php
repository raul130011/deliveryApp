<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;


#[ApiResource]
#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $adresseDepart = null;

    #[ORM\Column(length: 255)]
    private ?string $adresseArrivee = null;

    #[ORM\Column]
    private ?int $type = null;

    #[ORM\Column]
    private ?int $etat = null;

    #[ORM\Column]
    private ?int $creneau = null;

    #[ORM\Column]
    private ?float $prixHt = null;

    #[ORM\Column]
    private ?float $prixTtc = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?Livreur $Livreur = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?Client $Client = null;

    #[ORM\OneToMany(mappedBy: 'Commande', targetEntity: Colis::class)]
    private Collection $colis;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?PointRelais $PointRelais = null;

    #[ORM\Column]
    private ?bool $adresseClientDefault = null;

    #[ORM\Column(length: 20)]
    private ?string $codePostalDepart = null;

    #[ORM\Column(length: 255)]
    private ?string $villeDepart = null;

    #[ORM\Column(length: 255)]
    private ?string $paysDepart = null;

    #[ORM\Column(length: 20)]
    private ?string $codePostalArrivee = null;

    #[ORM\Column(length: 255)]
    private ?string $villeArrivee = null;

    #[ORM\Column(length: 255)]
    private ?string $paysArrivee = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?Facture $facture = null;

    public function __construct()
    {
        $this->colis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresseDepart(): ?string
    {
        return $this->adresseDepart;
    }

    public function setAdresseDepart(string $adresseDepart): self
    {
        $this->adresseDepart = $adresseDepart;

        return $this;
    }

    public function getAdresseArrivee(): ?string
    {
        return $this->adresseArrivee;
    }

    public function setAdresseArrivee(string $adresseArrivee): self
    {
        $this->adresseArrivee = $adresseArrivee;

        return $this;
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

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getCreneau(): ?int
    {
        return $this->creneau;
    }

    public function setCreneau(int $creneau): self
    {
        $this->creneau = $creneau;

        return $this;
    }

    public function getPrixHt(): ?float
    {
        return $this->prixHt;
    }

    public function setPrixHt(float $prixHt): self
    {
        $this->prixHt = $prixHt;

        return $this;
    }

    public function getPrixTtc(): ?float
    {
        return $this->prixTtc;
    }

    public function setPrixTtc(float $prixTtc): self
    {
        $this->prixTtc = $prixTtc;

        return $this;
    }

    public function getLivreur(): ?Livreur
    {
        return $this->Livreur;
    }

    public function setLivreur(?Livreur $Livreur): self
    {
        $this->Livreur = $Livreur;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->Client;
    }

    public function setClient(?Client $Client): self
    {
        $this->Client = $Client;

        return $this;
    }

    /**
     * @return Collection<int, Colis>
     */
    public function getColis(): Collection
    {
        return $this->colis;
    }

    public function addColi(Colis $coli): self
    {
        if (!$this->colis->contains($coli)) {
            $this->colis->add($coli);
            $coli->setCommande($this);
        }

        return $this;
    }

    public function removeColi(Colis $coli): self
    {
        if ($this->colis->removeElement($coli)) {
            // set the owning side to null (unless already changed)
            if ($coli->getCommande() === $this) {
                $coli->setCommande(null);
            }
        }

        return $this;
    }

    public function getPointRelais(): ?PointRelais
    {
        return $this->PointRelais;
    }

    public function setPointRelais(?PointRelais $PointRelais): self
    {
        $this->PointRelais = $PointRelais;

        return $this;
    }

    public function isAdresseClientDefault(): ?bool
    {
        return $this->adresseClientDefault;
    }

    public function setAdresseClientDefault(bool $adresseClientDefault): self
    {
        $this->adresseClientDefault = $adresseClientDefault;

        return $this;
    }

    public function getCodePostalDepart(): ?string
    {
        return $this->codePostalDepart;
    }

    public function setCodePostalDepart(string $codePostalDepart): self
    {
        $this->codePostalDepart = $codePostalDepart;

        return $this;
    }

    public function getVilleDepart(): ?string
    {
        return $this->villeDepart;
    }

    public function setVilleDepart(string $villeDepart): self
    {
        $this->villeDepart = $villeDepart;

        return $this;
    }

    public function getPaysDepart(): ?string
    {
        return $this->paysDepart;
    }

    public function setPaysDepart(string $paysDepart): self
    {
        $this->paysDepart = $paysDepart;

        return $this;
    }

    public function getCodePostalArrivee(): ?string
    {
        return $this->codePostalArrivee;
    }

    public function setCodePostalArrivee(string $codePostalArrivee): self
    {
        $this->codePostalArrivee = $codePostalArrivee;

        return $this;
    }

    public function getVilleArrivee(): ?string
    {
        return $this->villeArrivee;
    }

    public function setVilleArrivee(string $villeArrivee): self
    {
        $this->villeArrivee = $villeArrivee;

        return $this;
    }

    public function getPaysArrivee(): ?string
    {
        return $this->paysArrivee;
    }

    public function setPaysArrivee(string $paysArrivee): self
    {
        $this->paysArrivee = $paysArrivee;

        return $this;
    }

    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    public function setFacture(?Facture $facture): self
    {
        $this->facture = $facture;

        return $this;
    }
}
