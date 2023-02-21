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
    private ?User $firstUser = null;

    #[ORM\ManyToOne(inversedBy: 'deals')]
    private ?User $secondUser = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'deals')]
    private ?Items $firstUserObject = null;

    #[ORM\ManyToOne(inversedBy: 'deals')]
    private ?Items $secondUserObject = null;

    #[ORM\Column(nullable: true)]
    private ?bool $firstUserResponse = null;

    #[ORM\Column(nullable: true)]
    private ?bool $secondeUserResponse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstUser(): ?User
    {
        return $this->firstUser;
    }

    public function setFirstUser(?User $firstUser): self
    {
        $this->firstUser = $firstUser;

        return $this;
    }

    public function getSecondUser(): ?User
    {
        return $this->secondUser;
    }

    public function setSecondUser(?User $secondUser): self
    {
        $this->secondUser = $secondUser;

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

    public function getFirstUserObject(): ?Items
    {
        return $this->firstUserObject;
    }

    public function setFirstUserObject(?Items $firstUserObject): self
    {
        $this->firstUserObject = $firstUserObject;

        return $this;
    }

    public function getSecondUserObject(): ?Items
    {
        return $this->secondUserObject;
    }

    public function setSecondUserObject(?Items $secondUserObject): self
    {
        $this->secondUserObject = $secondUserObject;

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
