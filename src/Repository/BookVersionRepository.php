<?php

namespace App\Repository;

use App\Entity\BookVersion;
use App\Entity\Borrowing;
use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BookVersion>
 *
 * @method BookVersion|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookVersion|null findOneBy(array $criteria, array $orderBy = null)
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

    public function findAll(): array
    {
        $qb = $this->createQueryBuilder('bv')
            ->addSelect('b')
            ->addSelect('a')
            ->addSelect('p')
            ->innerJoin('bv.book', 'b')
            ->innerJoin('b.authors', 'a')
            ->innerJoin('bv.publisher', 'p')
        ;

        return $qb->getQuery()->getResult();
    }

    public function findAllBookVersionCanBeReserved(int $userId): array
    {
        $qb = $this->createQueryBuilder('bv')
            ->addSelect('b')
            ->addSelect('a')
            ->addSelect('p')
            ->innerJoin('bv.book', 'b')
            ->innerJoin('b.authors', 'a')
            ->innerJoin('bv.publisher', 'p')
            ->innerJoin(
                Borrowing::class,
                'bor',
                Join::WITH,
                'bor.bookVersion = bv.id'
            )
            ->leftJoin(
                Reservation::class,
                'r',
                Join::WITH,
                'r.bookVersion = bv.id'
            )
            ->where('
                reservation.bookVersion IS NULL
                OR NOT EXISTS (
                    SELECT 1
                    FROM ' . Reservation::class . ' r1
                    WHERE r1.bookVersion = bv.id
                    AND r1.isActive = true
                )
            ')
            ->andWhere('
                bor.returned = false
                AND bor.user != :userId
            ')
            ->setParameter('userId', $userId)
        ;

        return $qb->getQuery()->getResult();
    }

    public function findAllBookVersionCanBeBorrowed(int $userId): array
    {
        $qb = $this->createQueryBuilder('bv')
            ->addSelect('b')
            ->addSelect('a')
            ->addSelect('p')
            ->innerJoin('bv.book', 'b')
            ->innerJoin('b.authors', 'a')
            ->innerJoin('bv.publisher', 'p')
            ->leftJoin(
                Borrowing::class,
                'bor',
                Join::WITH,
                'bor.bookVersion = bv.id'
            )
            ->leftJoin(
                Reservation::class,
                'r',
                Join::WITH,
                'r.bookVersion = bv.id'
            )
            ->where('bor.bookVersion IS NULL')
            ->orWhere('
                NOT EXISTS (
                    SELECT 1
                    FROM ' . Reservation::class . ' r1
                    WHERE r1.bookVersion = bv.id
                    AND r1.isActive = true
                )
            ')
            ->orWhere('
                r.isActive = true
                AND r.user = :userId
            ')
            ->orWhere('
                CURRENT_DATE() >= DATE_ADD(bor.returnDate, 3, \'DAY\')
                AND r.isActive = true
                AND r.user != :userId
            ')
            ->andWhere('
                NOT EXISTS (
                    SELECT 1
                    FROM ' . Borrowing::class . ' b1
                    WHERE b1.bookVersion = bv.id
                    AND b1.returned = false
                )
            ')
            ->setParameter('userId', $userId)
        ;

        return $qb->getQuery()->getResult();
    }
}
