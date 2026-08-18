<?php
namespace App\Factory;

use App\DTO\MediaItemDTO;
use App\Entity\Book;
use App\Entity\Cd;
use App\Entity\Dvd;
use App\Entity\MediaItem;

class MediaItemFactory
{
    public function createFromDto(MediaItemDTO $dto): MediaItem
    {
        $item = match ($dto->type) {
            'book' => (new Book())->setAuthor($dto->author),
            'cd' => (new Cd())->setArtist($dto->artist),
            'dvd' => (new Dvd())->setDirector($dto->director),
            default => throw new \InvalidArgumentException('Invalid type'),
        };

        $this->updateEntityFromDto($item, $dto);

        return $item;
    }

    public function updateEntityFromDto(MediaItem $item, MediaItemDTO $dto): void
    {
        $item->setTitle($dto->title);
        $item->setDescription($dto->description);
        $item->setAcquisitionDate($dto->acquisitionDate);
        $item->setBorrowedTo($dto->borrowedTo);

        if ($item instanceof Book) {
            $item->setAuthor($dto->author);
        } elseif ($item instanceof Cd) {
            $item->setArtist($dto->artist);
        } elseif ($item instanceof Dvd) {
            $item->setDirector($dto->director);
        }
    }
}
