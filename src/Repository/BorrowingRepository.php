<?php

namespace App\Repository;

use App\Entity\Borrowing;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Borrowing>
 *
 * @method Borrowing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Borrowing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Borrowing[]    findAll()
 * @method Borrowing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BorrowingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Borrowing::class);
    }

    public function save(Borrowing $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Borrowing $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllActive(): ?array
    {
        return $this->createQueryBuilder('b')
            ->where('b.returned = false')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findActiveByUserId(int $value): ?array
    {
        return $this->createQueryBuilder('b')
            ->where('b.returned = false')
            ->andWhere('b.user = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByUserId(int $value): ?array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.user = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findBorrowingsSoonCompleted(): ?array
    {
        return $this->createQueryBuilder('b')
            ->where('CURRENT_DATE() = DATE_SUB(b.returnDate, 3, \'DAY\')')
            ->andWhere('b.returned = false')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findBorrowingsPastUncompletedByUser(User $user): ?array
    {
        return $this->createQueryBuilder('b')
            ->where('CURRENT_DATE() > b.returnDate')
            ->andWhere('b.returned = false')
            ->andWhere('b.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
    }
}
