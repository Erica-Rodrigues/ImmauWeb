<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotoRepository::class)]
#[ORM\Table(name: "photos")]
class Photo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $urlPhoto = null;

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
}
