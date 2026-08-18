<?php

namespace App\Repository;

use App\Entity\MediaItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MediaItem>
 *
 * @method MediaItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method MediaItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method MediaItem[]    findAll()
 * @method MediaItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediaItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MediaItem::class);
    }

    public function findAllByType(?string $type): array
    {
        if (!$type) {
            return $this->findAll();
        }

        $classMap = [
            'book' => \App\Entity\Book::class,
            'cd'   => \App\Entity\Cd::class,
            'dvd'  => \App\Entity\Dvd::class,
        ];

        // Pokud by někdo podvrhl URL, vrátíme raději vše (nebo prázdné pole [])
        if (!isset($classMap[$type])) {
            return $this->findAll();
        }

        // Využijeme EntityManager, aby nám automaticky sáhl do správného repozitáře (Book/Cd/Dvd)
        return $this->getEntityManager()->getRepository($classMap[$type])->findAll();
    }
}
