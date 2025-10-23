<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: PhotoRepository::class)]
#[ORM\Table(name: "photos")]
#[ApiResource()]
class Photo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $urlPhoto = null;

    #[ORM\OneToOne(mappedBy: 'photo')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'photos')]
    private ?Bien $bien = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrlPhoto(): ?string
    {
        return $this->urlPhoto;
    }

    public function setUrlPhoto(string $urlPhoto): static
    {
        $this->urlPhoto = $urlPhoto;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
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
            'nom' => $this->getUrlPhoto(),
            'user' => $this->getUser(),
            'bien' => $this->getBien()
        ];
    }
}
