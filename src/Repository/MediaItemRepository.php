<?php

namespace App\Repository;

use App\Entity\MediaItem;
use App\Entity\Book;
use App\Entity\Cd;
use App\Entity\Dvd;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MediaItem>
 */
class MediaItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MediaItem::class);
    }

    /**
     * @return MediaItem[]
     */
    public function findFilteredItems(?string $type = null, bool $isBorrowed = false): array
    {
        $entityClass = match ($type) {
            'book' => Book::class,
            'cd'   => Cd::class,
            'dvd'  => Dvd::class,
            default => null,
        };

        $repository = $entityClass
            ? $this->getEntityManager()->getRepository($entityClass)
            : $this;

        $qb = $repository->createQueryBuilder('m')
            ->orderBy('m.title', 'ASC');

        if ($isBorrowed) {
            $qb->andWhere('m.borrowedTo IS NOT NULL AND m.borrowedTo != :emptyString')
                ->setParameter('emptyString', '');
        }
        return $qb->getQuery()->getResult();
    }
}
