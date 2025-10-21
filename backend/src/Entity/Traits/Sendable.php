<?php
namespace App\Entity\Traits;
use Doctrine\ORM\Mapping as ORM;

trait Sendable
{
    #[ORM\Column]
    private ?\DateTimeImmutable $dateEnvoi = null;

    public function getDateEnvoi(): ?\DateTimeImmutable
    {
        return $this->dateEnvoi;
    }

    public function setDateEnvoi(\DateTimeImmutable $dateEnvoi): static
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }


    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateTimestamps(){
        if ($this->getDateEnvoi() === null) {
            $this->setDateEnvoi(new \DateTimeImmutable);
        }
    }
}