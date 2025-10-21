<?php

namespace App\Entity;

use App\Repository\CritereRepository;
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
}
