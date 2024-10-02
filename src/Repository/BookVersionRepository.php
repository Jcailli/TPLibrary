<?php

namespace App\Repository;

use App\Entity\BookVersion;
use App\Entity\Borrowing;
use App\Entity\Reservation;
use DateInterval;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BookVersion>
 *
 * @method BookVersion|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookVersion|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookVersion[]    findAll()
 * @method BookVersion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookVersionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookVersion::class);
    }

    public function save(BookVersion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(BookVersion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllBookVersionBorrowed(int $userId): array
    {
        $qb = $this->createQueryBuilder('b')
        ->innerJoin(
            Borrowing::class,
            'borrowing',
            'WITH',
            'borrowing.bookVersion = b.id'
        )
        ->leftJoin(
            Reservation::class,
            'reservation',
            'WITH',
            'reservation.bookVersion = b.id'
        )
        ->where('reservation.bookVersion IS NULL')
        ->andWhere('borrowing.user != :userId')
        ->andWhere('borrowing.returned = false')
        ->setParameter('userId', $userId);

        return $qb->getQuery()->getResult();
    }

    public function findAllBookVersionNotBorrowedAndNotReserved(): array
    {
        $qb = $this->createQueryBuilder('b')
        ->leftJoin(
            Borrowing::class,
            'borrowing',
            'WITH',
            'borrowing.bookVersion = b.id'
        )
        ->leftJoin(
            Reservation::class,
            'reservation',
            'WITH',
            'reservation.bookVersion = b.id'
        )
        ->where('reservation.bookVersion IS NULL')
        ->andWhere('reservation.isActive = false OR reservation.isActive IS NULL')
        ->andWhere('borrowing.bookVersion IS NULL')
        ->andWhere('borrowing.returned = true OR borrowing.returned IS NULL');

        return $qb->getQuery()->getResult();
    }
}
