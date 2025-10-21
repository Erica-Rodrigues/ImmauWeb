<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\RechercheRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RechercheRepository::class)]
#[ORM\Table(name: "recherches")]
#[ORM\HasLifecycleCallbacks]
class Recherche
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomRecherche = null;

    #[ORM\Column]
    private ?bool $alerte = null;

    #[ORM\ManyToOne(inversedBy: 'recherches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'recherches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Critere $critere = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomRecherche(): ?string
    {
        return $this->nomRecherche;
    }

    public function setNomRecherche(string $nomRecherche): static
    {
        $this->nomRecherche = $nomRecherche;

        return $this;
    }

    use Timestampable;

    public function isAlerte(): ?bool
    {
        return $this->alerte;
    }

    public function setAlerte(bool $alerte): static
    {
        $this->alerte = $alerte;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCritere(): ?Critere
    {
        return $this->critere;
    }

    public function setCritere(?Critere $critere): static
    {
        $this->critere = $critere;

        return $this;
    }
}
