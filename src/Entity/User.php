<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Traits\TimestampableTrait;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Ignore;



#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'Un compte correspondant à cette adresse exist déjà.')]
#[Vich\Uploadable]
class User implements UserInterface, PasswordAuthenticatedUserInterface,  \Serializable
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[Length(min: 6)]
    private ?string $plainPassword = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $isEmailVerified = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    /**
     * @Vich\UploadableField(mapping="users", fileNameProperty="image")
     * @Ignore()
     */
    #[Vich\UploadableField(mapping: 'users_images', fileNameProperty: 'image')]
    #[Assert\Image(
        maxSize: '2M',
        mimeTypes: ['image/png', 'image/jpeg'],
        maxSizeMessage: 'Votre fichier fait {{ size }} et ne doit pas dépasser {{ limit }}',
        mimeTypesMessage: 'Fichier accepté : png / jpeg'
    )]
    private ?File $imageFile = null;

    #[ORM\OneToMany(mappedBy: 'swipper', targetEntity: Swipe::class)]
    private Collection $swipes;

    #[ORM\OneToMany(mappedBy: 'firstUser', targetEntity: Matches::class)]
    private Collection $matches;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Items::class)]
    private Collection $items;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'users')]
    private Collection $category;

    #[ORM\OneToMany(mappedBy: 'requestedBy', targetEntity: VerificationRequest::class)]
    private Collection $verificationRequests;

    #[ORM\OneToMany(mappedBy: 'firstUser', targetEntity: Channel::class)]
    private Collection $channels;

    #[ORM\OneToMany(mappedBy: 'sender', targetEntity: Message::class)]
    private Collection $messages;

    #[ORM\OneToMany(mappedBy: 'firstUser', targetEntity: Deal::class)]
    private Collection $deals;

    #[ORM\OneToMany(mappedBy: 'favSender', targetEntity: Favorite::class, orphanRemoval: true)]
    private Collection $favorites;

    public function __construct()
    {
        $this->matches = new ArrayCollection();
        $this->channels = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->items = new ArrayCollection();
        $this->swipes = new ArrayCollection();
        $this->category = new ArrayCollection();
        $this->verificationRequests = new ArrayCollection();
        $this->deals = new ArrayCollection();
        $this->favorites = new ArrayCollection();
    }

    // #[ORM\Column(length: 255)]
    // private ?string $email = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    // public function setId(string $id): self
    // {
    //     $this->id = $id;

    //     return $this;
    // }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string|null $plainPassword
     * @return User
     */
    public function setPlainPassword(?string $plainPassword): User
    {
        $this->plainPassword = $plainPassword;

        if ($plainPassword) {
            $this->setUpdatedAt(new \DateTime());
        }

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


    public function isIsEmailVerified(): ?bool
    {
        return $this->isEmailVerified;
    }

    public function setIsEmailVerified(bool $isEmailVerified): self
    {
        $this->isEmailVerified = $isEmailVerified;

        return $this;
    }

    /**
     * @return Collection<int, Swipe>
     */
    public function getSwipes(): Collection
    {
        return $this->swipes;
    }

    public function addSwipe(Swipe $swipe): self
    {
        if (!$this->swipes->contains($swipe)) {
            $this->swipes->add($swipe);
            $swipe->setSwipperId($this);
        }

        return $this;
    }

    public function removeSwipe(Swipe $swipe): self
    {
        if ($this->swipes->removeElement($swipe)) {
            // set the owning side to null (unless already changed)
            if ($swipe->getSwipperId() === $this) {
                $swipe->setSwipperId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Matches>
     */
    public function getMatches(): Collection
    {
        return $this->matches;
    }

    public function addMatch(Matches $match): self
    {
        if (!$this->matches->contains($match)) {
            $this->matches->add($match);
            $match->setFirstUserId($this);
        }

        return $this;
    }

    public function removeMatch(Matches $match): self
    {
        if ($this->matches->removeElement($match)) {
            // set the owning side to null (unless already changed)
            if ($match->getFirstUserId() === $this) {
                $match->setFirstUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Items>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Items $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setOwner($this);
        }

        return $this;
    }

    public function removeItem(Items $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getOwner() === $this) {
                $item->setOwner(null);
            }
        }

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
            $verificationRequest->setRequestedBy($this);
        }

        return $this;
    }

    public function removeVerificationRequest(VerificationRequest $verificationRequest): self
    {
        if ($this->verificationRequests->removeElement($verificationRequest)) {
            // set the owning side to null (unless already changed)
            if ($verificationRequest->getRequestedBy() === $this) {
                $verificationRequest->setRequestedBy(null);
            }
        }
        return $this;
    }

     //* SETTERS AND GETTERS OF IMAGES 
    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     * @return User
     */
    public function setImage(?string $image): User
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param mixed $imageFile
     * @return User
     */
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;
        //!important de rajouter ça 
        if ($imageFile) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
     }
     
    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setSender($this);
        }

        return $this;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->email,
            $this->password,
        ) = unserialize($serialized);
    }
    
    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getSender() === $this) {
                $message->setSender(null);
            }
        }
        return $this;
    }

    public function __toString()
    {
        return $this->name;
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
            $deal->setFirstUserId($this);
        }
        
        return $this;
    }
    
    /**
     * @return Collection<int, Favorite>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Favorite $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites->add($favorite);
            $favorite->setFavSender($this);
        }

        return $this;
    }

    public function removeDeal(Deal $deal): self
    {
        if ($this->deals->removeElement($deal)) {
            // set the owning side to null (unless already changed)
            if ($deal->getFirstUserId() === $this) {
                $deal->setFirstUserId(null);    
            }
        }

        return $this;
    }

    public function removeFavorite(Favorite $favorite): self
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getFavSender() === $this) {
                $favorite->setFavSender(null);
            }
        }

        return $this;
    }

    public function hasRoles($role)
    {
        return in_array($role, $this->roles);
    }
}
