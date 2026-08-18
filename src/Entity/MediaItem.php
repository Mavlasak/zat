<?php

namespace App\Entity;

use App\Repository\MediaItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MediaItemRepository::class)]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap(["book" => "Book", "cd" => "Cd", "dvd" => "Dvd", "media" => "MediaItem"])]
class MediaItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $acquisitionDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $borrowedTo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAcquisitionDate(): ?\DateTimeInterface
    {
        return $this->acquisitionDate;
    }

    public function setAcquisitionDate(?\DateTimeInterface $acquisitionDate): static
    {
        $this->acquisitionDate = $acquisitionDate;

        return $this;
    }

    public function getBorrowedTo(): ?string
    {
        return $this->borrowedTo;
    }

    public function setBorrowedTo(?string $borrowedTo): static
    {
        $this->borrowedTo = $borrowedTo;

        return $this;
    }

    public function getTypeName(): string
    {
        $path = explode('\\', static::class);
        return array_pop($path);
    }
}
