<?php

namespace App\Entity;

use App\Repository\DealRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DealRepository::class)]
class Deal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'deals')]
    private ?User $firstUserId = null;

    #[ORM\ManyToOne(inversedBy: 'deals')]
    private ?User $secondUserId = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'deals')]
    private ?Items $firstUserObjectId = null;

    #[ORM\ManyToOne(inversedBy: 'deals')]
    private ?Items $secondUserObjectId = null;

    #[ORM\Column(nullable: true)]
    private ?bool $firstUserResponse = null;

    #[ORM\Column(nullable: true)]
    private ?bool $secondeUserResponse = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getFirstUserObjectId(): ?Items
    {
        return $this->firstUserObjectId;
    }

    public function setFirstUserObjectId(?Items $firstUserObjectId): self
    {
        $this->firstUserObjectId = $firstUserObjectId;

        return $this;
    }

    public function getSecondUserObjectId(): ?Items
    {
        return $this->secondUserObjectId;
    }

    public function setSecondUserObjectId(?Items $secondUserObjectId): self
    {
        $this->secondUserObjectId = $secondUserObjectId;

        return $this;
    }

    public function isFirstUserResponse(): ?bool
    {
        return $this->firstUserResponse;
    }

    public function setFirstUserResponse(?bool $firstUserResponse): self
    {
        $this->firstUserResponse = $firstUserResponse;

        return $this;
    }

    public function isSecondeUserResponse(): ?bool
    {
        return $this->secondeUserResponse;
    }

    public function setSecondeUserResponse(?bool $secondeUserResponse): self
    {
        $this->secondeUserResponse = $secondeUserResponse;

        return $this;
    }
}
