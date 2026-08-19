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

        $item->setTitle($dto->title);
        $item->setDescription($dto->description);
        $item->setAcquisitionDate($dto->acquisitionDate);
        $item->setBorrowedTo($dto->borrowedTo);

        return $item;
    }
}
