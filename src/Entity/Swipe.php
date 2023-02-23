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
    private ?User $swipper = null;

    #[ORM\ManyToOne]
    private ?User $swipped = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isSwipeRight = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSwipper(): ?User
    {
        return $this->swipper;
    }

    public function setSwipper(?User $swipper): self
    {
        $this->swipper = $swipper;

        return $this;
    }

    public function getSwipped(): ?User
    {
        return $this->swipped;
    }

    public function setSwipped(?User $swipped): self
    {
        $this->swipped = $swipped;

        return $this;
    }

    public function getIsSwipeRight(): ?bool
    {
        return $this->isSwipeRight;
    }

    public function setIsSwipeRight(?bool $isSwipeRight): self
    {
        $this->isSwipeRight = $isSwipeRight;

        return $this;
    }
}
