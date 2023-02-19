<?php

namespace App\Entity;

use App\Repository\ObjectFilesRepository;
use App\Entity\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: ObjectFilesRepository::class)]
#[Vich\Uploadable]
class ObjectFiles
{

    use TimestampableTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

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

    #[ORM\ManyToOne(inversedBy: 'objectfile')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Items $item = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItemId(): ?Items
    {
        return $this->item;
    }

    public function setItemId(?Items $item): self
    {
        $this->item = $item;

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
     * @return ObjectFiles
     */
    public function setImage(?string $image): ObjectFiles
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
     * @return ObjectFiles
     */
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;
        if ($imageFile) {
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }

}
