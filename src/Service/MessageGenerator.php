<?php

namespace App\Service;

readonly class MessageGenerator
{
    public const string RESERVATION_READY = 'reservationReady';
    public const string BORROWING_SOON_COMPLETED = 'borrowingSoonCompleted';

    public function getSubjectMessage(string $subject): string
    {
        $subjectMessage = [
            self::RESERVATION_READY => 'The book you have reserved is available to borrow !',
            self::BORROWING_SOON_COMPLETED => 'The book you borrowed is about to expire !',
        ];
        return $subjectMessage[$subject];
    }

    public function getBodyTemplateMessage(string $body): string
    {
        $bodyMessage = [
            self::RESERVATION_READY => 'emails/reservation.html.twig',
            self::BORROWING_SOON_COMPLETED => 'emails/borrowing.html.twig',
        ];

        return $bodyMessage[$body];
    }
}
