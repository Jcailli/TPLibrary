<?php

namespace App\Service;

use App\Repository\BorrowingRepository;
use App\Repository\UserRepository;

readonly class BorrowingService
{
    public function __construct(
        private BorrowingRepository $borrowingRepository,
        private UserRepository      $userRepository,
        private MailService         $mailService,
        private PenalityService     $penalityService,
    ){}

    public function checkBorrowings3DaysLeftReturn(): void
    {
        $borrowings = $this->borrowingRepository->findBorrowingsSoonCompleted();

        if (null != $borrowings)
        {
            foreach ($borrowings as $borrowing)
            {
                $this->mailService->notifyUserBorrowingsSoonCompleted($borrowing->getUser(), $borrowing);
            }
        }
    }

    public function checkBorrowingsNotReturnedForPenality(): void
    {
        $users = $this->userRepository->findAllUsers();
        foreach ($users as $user) {
            $borrowings = $this->borrowingRepository->findBorrowingsPastUncompletedByUser($user);

            if (null != $borrowings)
            {
                $this->penalityService->updateUserPenality($borrowings, $user);
            }
        }
    }
}
