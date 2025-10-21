<?php
namespace App\Entity\Traits;
use Doctrine\ORM\Mapping as ORM;

trait Timestampable
{
    #[ORM\Column]
    private ?\DateTimeImmutable $dateCreation = null;

    public function getDateCreation(): ?\DateTimeImmutable
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeImmutable $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }


    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateTimestamps(){
        if ($this->getDateCreation() === null) {
            $this->setDateCreation(new \DateTimeImmutable);
        }
    }
}