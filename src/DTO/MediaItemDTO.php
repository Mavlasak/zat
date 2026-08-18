<?php
namespace App\DTO;

use App\Entity\Book;
use App\Entity\Cd;
use App\Entity\Dvd;
use App\Entity\MediaItem;

class MediaItemDTO
{
    public ?string $type = null;
    public ?string $title = null;
    public ?string $description = null;
    public ?\DateTimeInterface $acquisitionDate = null;
    public ?string $borrowedTo = null;

    public ?string $author = null;
    public ?string $artist = null;
    public ?string $director = null;

    public static function fromEntity(MediaItem $item): self
    {
        $dto = new self();
        $dto->title = $item->getTitle();
        $dto->description = $item->getDescription();
        $dto->acquisitionDate = $item->getAcquisitionDate();
        $dto->borrowedTo = $item->getBorrowedTo();

        if ($item instanceof Book) {
            $dto->type = 'book';
            $dto->author = $item->getAuthor();
        } elseif ($item instanceof Cd) {
            $dto->type = 'cd';
            $dto->artist = $item->getArtist();
        } elseif ($item instanceof Dvd) {
            $dto->type = 'dvd';
            $dto->director = $item->getDirector();
        }

        return $dto;
    }
}
