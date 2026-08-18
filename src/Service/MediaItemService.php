<?php

namespace App\Service;

use App\Entity\MediaItem;
use App\Factory\MediaItemFactory;
use App\Dto\MediaItemDto;
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

    public function createMediaItemFromDto(MediaItemDto $dto): MediaItem
    {
        $mediaItem = $this->mediaItemFactory->createFromDto($dto);
        $this->entityManager->persist($mediaItem);
        $this->entityManager->flush();

        return $mediaItem;
    }

    public function updateMediaItemFromDto(MediaItem $mediaItem, MediaItemDto $dto): void
    {
        $this->mediaItemFactory->updateEntityFromDto($mediaItem, $dto);
        $this->entityManager->flush();
    }

    public function removeMediaItem(MediaItem $mediaItem): void
    {
        $this->entityManager->remove($mediaItem);
        $this->entityManager->flush();
    }
}
