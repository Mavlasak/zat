<?php

namespace App\Entity;

use App\Repository\CdRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CdRepository::class)]
class Cd extends MediaItem
{
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $artist = null;

    public function getArtist(): ?string
    {
        return $this->artist;
    }

    public function setArtist(?string $artist): static
    {
        $this->artist = $artist;

        return $this;
    }
}
