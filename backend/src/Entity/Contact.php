<?php

namespace App\Entity;

use App\Entity\Traits\Sendable;
use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
#[ORM\Table(name: "contacts")]
#[ORM\HasLifecycleCallbacks]
#[ApiResource()]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $sujet = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    use Sendable;

    #[ORM\Column]
    private ?bool $traite = null;

    #[ORM\ManyToOne(inversedBy: 'contacts')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'contacts')]
    private ?Bien $bien = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): static
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function isTraite(): ?bool
    {
        return $this->traite;
    }

    public function setTraite(bool $traite): static
    {
        $this->traite = $traite;

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

    public function getBien(): ?Bien
    {
        return $this->bien;
    }

    public function setBien(?Bien $bien): static
    {
        $this->bien = $bien;

        return $this;
    }

    /**
     * @return array
     */
    public function __serialize(): array
    {
        return[
            'id' => $this->getId(),
            'nom' => $this->getNom(),
            'email' => $this->getEmail(),
            'sujet' => $this->getSujet(),
            'message' => $this->getMessage(),
            'isTraite' => $this->isTraite(),
            'dateEnvoie' => $this->getDateEnvoi()->format('d-m-Y'),
            'user' => $this->getUser(),
            'bien' => $this->getBien()
        ];
    }
}
