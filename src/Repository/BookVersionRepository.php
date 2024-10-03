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

    public function findAllBookVersionCanBeReserved(int $userId): array
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
        ->where('
            reservation.bookVersion IS NULL
            OR NOT EXISTS (
                SELECT 1
                FROM ' . Reservation::class . ' r
                WHERE r.bookVersion = b.id
                AND r.isActive = true
            )
        ')
        ->andWhere('
            borrowing.returned = false
            AND borrowing.user != :userId
        ')
        ->setParameter('userId', $userId);

        return $qb->getQuery()->getResult();
    }

    public function findAllBookVersionCanBeBorrowed(int $userId): array
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
        ->where('borrowing.bookVersion IS NULL')
        ->orWhere('
            NOT EXISTS (
                SELECT 1
                FROM ' . Borrowing::class . ' b1
                WHERE b1.bookVersion = b.id
                AND b1.returned = false
            )
            AND NOT EXISTS (
                SELECT 1
                FROM ' . Reservation::class . ' r
                WHERE r.bookVersion = b.id
                AND r.isActive = true
            )
        ')
        ->orWhere('
            borrowing.returned = true
            AND reservation.isActive = true
            AND reservation.user = :userId
        ')
        ->orWhere('
            borrowing.returned = true
            AND CURRENT_DATE() >= DATE_ADD(borrowing.returnDate, 3, \'DAY\')
            AND reservation.isActive = true
            AND reservation.user != :userId
        ')
        ->setParameter('userId', $userId);

        return $qb->getQuery()->getResult();
    }
}
