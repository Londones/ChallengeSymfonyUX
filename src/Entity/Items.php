<?php

namespace App\Entity;

use App\Repository\ItemsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

#[ORM\Entity(repositoryClass: ItemsRepository::class)]
class Items
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = "disponible";  //par défaut

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $isVerified = false;

    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?User $owner = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'items')]
    private Collection $category;

    #[ORM\OneToMany(mappedBy: 'itemRequested', targetEntity: VerificationRequest::class)]
    private Collection $verificationRequests;
    #[ORM\OneToMany(mappedBy: 'firstUserObjectId', targetEntity: Deal::class)]
    private Collection $deals;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->verificationRequests = new ArrayCollection();
        $this->deals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(?bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, VerificationRequest>
     */
    public function getVerificationRequests(): Collection
    {
        return $this->verificationRequests;
    }

    public function addVerificationRequest(VerificationRequest $verificationRequest): self
    {
        if (!$this->verificationRequests->contains($verificationRequest)) {
            $this->verificationRequests->add($verificationRequest);
            $verificationRequest->setItemRequested($this);
        }
        
        return $this;
    }
     
    /**
     * @return Collection<int, Deal>
     */
    public function getDeals(): Collection
    {
        return $this->deals;
    }

    public function addDeal(Deal $deal): self
    {
        if (!$this->deals->contains($deal)) {
            $this->deals->add($deal);
            $deal->setFirstUserObjectId($this);
        }

        return $this;
    }

    public function removeDeal(Deal $deal): self
    {
        if ($this->deals->removeElement($deal)) {
            // set the owning side to null (unless already changed)
            if ($deal->getFirstUserObjectId() === $this) {
                $deal->setFirstUserObjectId(null);
            }
        }

        return $this;
    }

    public function removeVerificationRequest(VerificationRequest $verificationRequest): self
    {
        if ($this->verificationRequests->removeElement($verificationRequest)) {
            // set the owning side to null (unless already changed)
            if ($verificationRequest->getItemRequested() === $this) {
                $verificationRequest->setItemRequested(null);
            }
        }

        return $this;
    }
    
    public function __toString()
    {
        return $this->name;
    }
}
