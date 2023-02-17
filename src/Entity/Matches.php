<?php

namespace App\Entity;

use App\Repository\MatchesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatchesRepository::class)]
class Matches
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'matches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $firstUserId = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $secondUserId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getFirstUserId(): ?User
    {
        return $this->firstUserId;
    }

    public function setFirstUserId(?User $firstUserId): self
    {
        $this->firstUserId = $firstUserId;

        return $this;
    }

    public function getSecondUserId(): ?User
    {
        return $this->secondUserId;
    }

    public function setSecondUserId(?User $secondUserId): self
    {
        $this->secondUserId = $secondUserId;

        return $this;
    }
}
