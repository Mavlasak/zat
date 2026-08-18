<?php

namespace App\Entity;

use App\Repository\DvdRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DvdRepository::class)]
class Dvd extends MediaItem
{
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $director = null;

    public function getDirector(): ?string
    {
        return $this->director;
    }

    public function setDirector(?string $director): static
    {
        $this->director = $director;

        return $this;
    }
}
