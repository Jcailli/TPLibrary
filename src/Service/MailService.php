<?php

namespace App\Service;

use App\Entity\Borrowing;
use App\Entity\Reservation;
use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

readonly class MailService
{
    public function __construct(
        private MessageGenerator $messageGenerator,
        private MailerInterface  $mailer
    ){}

    /**
     * @throws TransportExceptionInterface
     */
    public function notifyUserReservationReady(Reservation $reservation): bool
    {
        $subjectMail = $this->messageGenerator->getSubjectMessage(MessageGenerator::RESERVATION_READY);

        $bodyTemplate = $this->messageGenerator->getBodyTemplateMessage(MessageGenerator::RESERVATION_READY);

        $email = (new TemplatedEmail())
            ->from('no-replay@library.com')
            ->to($reservation->getUser()->getEmail())
            ->subject($subjectMail)
            ->htmlTemplate($bodyTemplate)
            ->context([
                'user' => $reservation->getUser(),
                'reservation' => $reservation,
            ]);

        $this->mailer->send($email);

        return true;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function notifyUserBorrowingsSoonCompleted(Borrowing $borrowing): bool
    {
        $subjectMail = $this->messageGenerator->getSubjectMessage(MessageGenerator::BORROWING_SOON_COMPLETED);

        $bodyTemplate = $this->messageGenerator->getBodyTemplateMessage(MessageGenerator::BORROWING_SOON_COMPLETED);

        $email = (new TemplatedEmail())
            ->from('no-reply@library.com')
            ->to($borrowing->getUser()->getEmail())
            ->subject($subjectMail)
            ->htmlTemplate($bodyTemplate)
            ->context([
                'user' => $borrowing->getUser(),
                'borrowing' => $borrowing
            ]);

        $this->mailer->send($email);

        return true;
    }
}
