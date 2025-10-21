<?php

namespace App\Entity;

use App\Repository\LocalisationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocalisationRepository::class)]
#[ORM\Table(name: "localisations")]
class Localisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomLocalite = null;

    #[ORM\Column(length: 255)]
    private ?string $codePostal = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(length: 255)]
    private ?string $pays = null;

    /**
     * @var Collection<int, Bien>
     */
    #[ORM\OneToMany(targetEntity: Bien::class, mappedBy: 'localisation', orphanRemoval: true)]
    private Collection $bien;

    /**
     * @var Collection<int, Critere>
     */
    #[ORM\OneToMany(targetEntity: Critere::class, mappedBy: 'localisation')]
    private Collection $critere;

    public function __construct()
    {
        $this->bien = new ArrayCollection();
        $this->critere = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomLocalite(): ?string
    {
        return $this->nomLocalite;
    }

    public function setNomLocalite(string $nomLocalite): static
    {
        $this->nomLocalite = $nomLocalite;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): static
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): static
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * @return Collection<int, Bien>
     */
    public function getBien(): Collection
    {
        return $this->bien;
    }

    public function addBien(Bien $bien): static
    {
        if (!$this->bien->contains($bien)) {
            $this->bien->add($bien);
            $bien->setLocalisation($this);
        }

        return $this;
    }

    public function removeBien(Bien $bien): static
    {
        if ($this->bien->removeElement($bien)) {
            // set the owning side to null (unless already changed)
            if ($bien->getLocalisation() === $this) {
                $bien->setLocalisation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Critere>
     */
    public function getCritere(): Collection
    {
        return $this->critere;
    }

    public function addCritere(Critere $critere): static
    {
        if (!$this->critere->contains($critere)) {
            $this->critere->add($critere);
            $critere->setLocalisation($this);
        }

        return $this;
    }

    public function removeCritere(Critere $critere): static
    {
        if ($this->critere->removeElement($critere)) {
            // set the owning side to null (unless already changed)
            if ($critere->getLocalisation() === $this) {
                $critere->setLocalisation(null);
            }
        }

        return $this;
    }
}
