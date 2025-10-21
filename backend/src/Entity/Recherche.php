<?php

namespace App\Entity;

use App\Repository\RechercheRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RechercheRepository::class)]
#[ORM\Table(name: "recherches")]
class Recherche
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomRecherche = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateCreation = null;

    #[ORM\Column]
    private ?bool $alerte = null;

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

    public function getDateCreation(): ?\DateTimeImmutable
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeImmutable $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function isAlerte(): ?bool
    {
        return $this->alerte;
    }

    public function setAlerte(bool $alerte): static
    {
        $this->alerte = $alerte;

        return $this;
    }
}
