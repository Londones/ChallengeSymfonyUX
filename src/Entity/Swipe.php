<?php

namespace App\Entity;

use App\Repository\SwipeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SwipeRepository::class)]
class Swipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'swipes')]
    private ?User $swipperId = null;

    #[ORM\ManyToOne]
    private ?User $swippedId = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isSwipeRight = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSwipperId(): ?User
    {
        return $this->swipperId;
    }

    public function setSwipperId(?User $swipperId): self
    {
        $this->swipperId = $swipperId;

        return $this;
    }

    public function getSwippedId(): ?User
    {
        return $this->swippedId;
    }

    public function setSwippedId(?User $swippedId): self
    {
        $this->swippedId = $swippedId;

        return $this;
    }

    public function isIsSwipeRight(): ?bool
    {
        return $this->isSwipeRight;
    }

    public function setIsSwipeRight(?bool $isSwipeRight): self
    {
        $this->isSwipeRight = $isSwipeRight;

        return $this;
    }
}
