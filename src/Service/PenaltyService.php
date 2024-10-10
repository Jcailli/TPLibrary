<?php

namespace App\Service;

use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

readonly class PenaltyService
{
    public function __construct (
        private EntityManagerInterface $entityManager,
    ){}

    public function updateUserPenalty(array $borrowings, User $user): void
    {
        $penalty = 0;
        foreach ($borrowings as $borrowing)
        {
            $penalty += intval((new DateTime())->diff($borrowing->getReturnDate())->format('%a'));
        }

        $user->setPenalty($penalty);

        $this->entityManager->flush();
    }
}
