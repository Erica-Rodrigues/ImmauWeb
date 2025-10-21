<?php
namespace App\Entity\Traits;
use Doctrine\ORM\Mapping as ORM;

trait Publishable
{
    #[ORM\Column]
    private ?\DateTimeImmutable $datePublication = null;

    public function getDatePublication(): ?\DateTimeImmutable
    {
        return $this->datePublication;
    }

    public function setDatePublication(\DateTimeImmutable $datePublication): static
    {
        $this->datePublication = $datePublication;

        return $this;
    }


    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateTimestamps(){
        if ($this->getDatePublication() === null) {
            $this->setDatePublication(new \DateTimeImmutable);
        }
    }
}