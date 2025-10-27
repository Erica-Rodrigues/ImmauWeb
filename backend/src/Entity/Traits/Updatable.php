<?php
namespace App\Entity\Traits;
use Doctrine\ORM\Mapping as ORM;

trait Updatable
{
    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }


    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateTimestamps(){
        $this->setUpdatedAt(new \DateTimeImmutable());
    }
}