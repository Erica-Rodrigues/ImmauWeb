<?php

namespace App\Entity;

use App\Repository\CritereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CritereRepository::class)]
#[ORM\Table(name: "criteres")]
class Critere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $typeTransaction = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $typeBien = null;

    #[ORM\Column(nullable: true)]
    private ?float $prixMin = null;

    #[ORM\Column(nullable: true)]
    private ?float $prixMax = null;

    #[ORM\Column(nullable: true)]
    private ?float $surfaceMin = null;

    #[ORM\Column(nullable: true)]
    private ?float $surfaceMax = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbChambres = null;

    #[ORM\ManyToOne(inversedBy: 'critere')]
    private ?Localisation $localisation = null;

    /**
     * @var Collection<int, Recherche>
     */
    #[ORM\OneToMany(targetEntity: Recherche::class, mappedBy: 'critere', orphanRemoval: true)]
    private Collection $recherches;

    public function __construct()
    {
        $this->recherches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeTransaction(): ?string
    {
        return $this->typeTransaction;
    }

    public function setTypeTransaction(?string $typeTransaction): static
    {
        $this->typeTransaction = $typeTransaction;

        return $this;
    }

    public function getTypeBien(): ?string
    {
        return $this->typeBien;
    }

    public function setTypeBien(?string $typeBien): static
    {
        $this->typeBien = $typeBien;

        return $this;
    }

    public function getPrixMin(): ?float
    {
        return $this->prixMin;
    }

    public function setPrixMin(?float $prixMin): static
    {
        $this->prixMin = $prixMin;

        return $this;
    }

    public function getPrixMax(): ?float
    {
        return $this->prixMax;
    }

    public function setPrixMax(?float $prixMax): static
    {
        $this->prixMax = $prixMax;

        return $this;
    }

    public function getSurfaceMin(): ?float
    {
        return $this->surfaceMin;
    }

    public function setSurfaceMin(?float $surfaceMin): static
    {
        $this->surfaceMin = $surfaceMin;

        return $this;
    }

    public function getSurfaceMax(): ?float
    {
        return $this->surfaceMax;
    }

    public function setSurfaceMax(?float $surfaceMax): static
    {
        $this->surfaceMax = $surfaceMax;

        return $this;
    }

    public function getNbChambres(): ?int
    {
        return $this->nbChambres;
    }

    public function setNbChambres(?int $nbChambres): static
    {
        $this->nbChambres = $nbChambres;

        return $this;
    }

    public function getLocalisation(): ?Localisation
    {
        return $this->localisation;
    }

    public function setLocalisation(?Localisation $localisation): static
    {
        $this->localisation = $localisation;

        return $this;
    }

    /**
     * @return Collection<int, Recherche>
     */
    public function getRecherches(): Collection
    {
        return $this->recherches;
    }

    public function addRecherch(Recherche $recherch): static
    {
        if (!$this->recherches->contains($recherch)) {
            $this->recherches->add($recherch);
            $recherch->setCritere($this);
        }

        return $this;
    }

    public function removeRecherch(Recherche $recherch): static
    {
        if ($this->recherches->removeElement($recherch)) {
            // set the owning side to null (unless already changed)
            if ($recherch->getCritere() === $this) {
                $recherch->setCritere(null);
            }
        }

        return $this;
    }
}
