<?php

namespace App\Entity;

use App\Repository\FavoriteRepository;
use DateTimeZone;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriteRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Favorite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'favorites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $favSender = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $favReceiver = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $creationDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFavSender(): ?User
    {
        return $this->favSender;
    }

    public function setFavSender(?User $favSender): self
    {
        $this->favSender = $favSender;

        return $this;
    }

    public function getFavReceiver(): ?User
    {
        return $this->favReceiver;
    }

    public function setFavReceiver(?User $favReceiver): self
    {
        $this->favReceiver = $favReceiver;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    #[ORM\PrePersist]
    public function setCreationDate(): self
    {
        $this->creationDate = new \DateTime('now', new DateTimeZone('Europe/Paris'));

        return $this;
    }
}
