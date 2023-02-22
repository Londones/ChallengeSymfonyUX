<?php

namespace App\Entity;

use App\Repository\VerificationRequestRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\TimestampableTrait;

#[ORM\Entity(repositoryClass: VerificationRequestRepository::class)]
class VerificationRequest
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'verificationRequests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $requestedBy = null;

    #[ORM\ManyToOne(inversedBy: 'verificationRequests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Items $itemRequested = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(length: 255)]
    private ?string $proofFiles = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRequestedBy(): ?User
    {
        return $this->requestedBy;
    }

    public function setRequestedBy(?User $requestedBy): self
    {
        $this->requestedBy = $requestedBy;

        return $this;
    }

    public function getItemRequested(): ?Items
    {
        return $this->itemRequested;
    }

    public function setItemRequested(?Items $itemRequested): self
    {
        $this->itemRequested = $itemRequested;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getProofFiles(): ?string
    {
        return $this->proofFiles;
    }

    public function setProofFiles(string $proofFiles): self
    {
        $this->proofFiles = $proofFiles;

        return $this;
    }
}
