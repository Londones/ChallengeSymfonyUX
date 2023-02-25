<?php

namespace App\Entity;

use App\Repository\VerificationRequestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\TimestampableTrait;
use Symfony\Component\HttpFoundation\File\UploadedFile;


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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $message = null;

    #[ORM\Column(length: 255)]
    private ?string $status = "En cours";

    #[ORM\OneToMany(mappedBy: 'request', targetEntity: Proof::class)]
    private Collection $proofs;

    public function __construct()
    {
        $this->proofs = new ArrayCollection();
    }

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }


    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return Collection<int, Proof>
     */

    public function getAttachProofs()
    {
        return $this->proofs;
    }

    public function setAttachProofs(array $files=array())
    {
        if (!$files) return [];
        foreach ($files as $file) {
            if (!$file) return [];
            $this->attachProof($file);
        }
        return [];
    }

    public function attachProof(UploadedFile $file=null)
    {
        if (!$file) {
            return;
        }
        $proof = new Proof();
        $proof->setImageFile($file);
        $this->addProof($proof);
    }
    public function getProofs(): Collection
    {
        return $this->proofs;
    }

    public function addProof(Proof $proof): self
    {
        if (!$this->proofs->contains($proof)) {
            $this->proofs->add($proof);
            $proof->setRequest($this);
        }

        return $this;
    }

    public function removeProof(Proof $proof): self
    {
        if ($this->proofs->removeElement($proof)) {
            // set the owning side to null (unless already changed)
            if ($proof->getRequest() === $this) {
                $proof->setRequest(null);
            }
        }

        return $this;
    }
}
