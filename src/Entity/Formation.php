<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormationRepository::class)]
class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'formations')]
    private ?Eleve $Formation = null;

    #[ORM\Column(length: 255)]
    private ?string $SIO = null;

    #[ORM\Column(length: 255)]
    private ?string $Banque = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFormation(): ?Eleve
    {
        return $this->Formation;
    }

    public function setFormation(?Eleve $Formation): self
    {
        $this->Formation = $Formation;

        return $this;
    }

    public function getSIO(): ?string
    {
        return $this->SIO;
    }

    public function setSIO(string $SIO): self
    {
        $this->SIO = $SIO;

        return $this;
    }

    public function getBanque(): ?string
    {
        return $this->Banque;
    }

    public function setBanque(string $Banque): self
    {
        $this->Banque = $Banque;

        return $this;
    }
}
