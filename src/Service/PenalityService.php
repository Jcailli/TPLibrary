<?php

namespace App\Service;

use App\Entity\Borrowing;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

readonly class PenalityService
{
    public function __construct (
        private EntityManagerInterface $entityManager,
    ){}

    public function updateUserPenality(array $borrowings, User $user): void
    {
        $penality = 0;
        foreach ($borrowings as $borrowing)
        {
            $penality += intval((new DateTime())->diff($borrowing->getReturnDate())->format('%a'));
        }

        $user->setPenality($penality);

        $this->entityManager->flush();
    }
}
