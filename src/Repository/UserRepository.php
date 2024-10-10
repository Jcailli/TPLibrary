<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function findUserDetailsById(int $id): object|null
    {
        $qb = $this->createQueryBuilder('u')
            ->addSelect('b')
            ->addSelect('bbv')
            ->addSelect('bbvb')
            ->addSelect('bbvba')
            ->addSelect('bbvp')
            ->addSelect('r')
            ->addSelect('rbv')
            ->addSelect('rbvb')
            ->addSelect('rbvba')
            ->addSelect('rbvp')
            ->innerJoin('u.borrowings','b')
            ->innerJoin('b.bookVersion', 'bbv')
            ->innerJoin('bbv.book', 'bbvb')
            ->innerJoin('bbv.publisher', 'bbvp')
            ->innerJoin('bbvb.authors', 'bbvba')
            ->innerJoin('u.reservations', 'r')
            ->innerJoin('r.bookVersion', 'rbv')
            ->innerJoin('rbv.book', 'rbvb')
            ->innerJoin('rbvb.authors', 'rbvba')
            ->innerJoin('rbv.publisher', 'rbvp')
            ->where('u.id = :userId')
            ->setParameter('userId', $id)
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findAllUsers(): ?array
    {
        $qb = $this->createQueryBuilder('u')
            ->where("u.roles LIKE '%ROLE_USER%'")
        ;

        return $qb->getQuery()->getResult();
    }

    public function findAllPenaltyUsers(): ?array
    {
        $qb = $this->createQueryBuilder('u')
            ->where("u.penalty > 0")
            ->andWhere("u.penalty IS NOT NULL")
            ->andWhere("u.roles LIKE '%ROLE_USER%'")
        ;

        return $qb->getQuery()->getResult();
    }
}
