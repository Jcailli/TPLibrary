<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 *
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function save(Reservation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Reservation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllActiveByUserId(int $userId): ?array
    {
        $qb = $this->createQueryBuilder('r')
            ->addSelect('u')
            ->addSelect('bv')
            ->addSelect('book')
            ->innerJoin('r.user', 'u')
            ->innerJoin('r.bookVerion', 'bv')
            ->innerJoin('bv.book', 'book')
            ->where('r.user = :userId')
            ->andWhere('r.isActive = true')
            ->setParameter('userId', $userId)
        ;
        return $qb->getQuery()->getResult();
    }

    public function findAllActive(): ?array
    {
        $qb = $this->createQueryBuilder('r')
            ->addSelect('u')
            ->addSelect('bv')
            ->addSelect('book')
            ->innerJoin('r.user', 'u')
            ->innerJoin('r.bookVersion', 'bv')
            ->innerJoin('bv.book', 'book')
            ->where('r.isActive = true')
        ;
        return $qb->getQuery()->getResult();
    }
}
