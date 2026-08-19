<?php

namespace App\Service;

use App\Entity\MediaItem;
use App\Factory\MediaItemFactory;
use App\DTO\MediaItemDTO;
use App\Entity\Book;
use App\Entity\Cd;
use App\Entity\Dvd;
use Doctrine\ORM\EntityManagerInterface;

class MediaItemService
{
    private MediaItemFactory $mediaItemFactory;
    private EntityManagerInterface $entityManager;

    public function __construct(MediaItemFactory $mediaItemFactory, EntityManagerInterface $entityManager)
    {
        $this->mediaItemFactory = $mediaItemFactory;
        $this->entityManager = $entityManager;
    }

    public function createMediaItemFromDto(MediaItemDTO $dto): MediaItem
    {
        $mediaItem = $this->mediaItemFactory->createFromDto($dto);
        $this->entityManager->persist($mediaItem);
        $this->entityManager->flush();

        return $mediaItem;
    }

    public function updateMediaItemFromDto(MediaItem $mediaItem, MediaItemDTO $dto): void
    {
        $mediaItem->setTitle($dto->title);
        $mediaItem->setDescription($dto->description);
        $mediaItem->setAcquisitionDate($dto->acquisitionDate);
        $mediaItem->setBorrowedTo($dto->borrowedTo);

        if ($mediaItem instanceof Book) {
            $mediaItem->setAuthor($dto->author);
        } elseif ($mediaItem instanceof Cd) {
            $mediaItem->setArtist($dto->artist);
        } elseif ($mediaItem instanceof Dvd) {
            $mediaItem->setDirector($dto->director);
        }

        $this->entityManager->flush();
    }

    public function removeMediaItem(MediaItem $mediaItem): void
    {
        $this->entityManager->remove($mediaItem);
        $this->entityManager->flush();
    }
}
