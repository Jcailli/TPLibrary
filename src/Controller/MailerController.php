<?php

namespace App\Controller;

use App\Entity\BookVersion;
use App\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/email')]
class MailerController extends AbstractController
{
    public function __construct(
        private readonly LoggerInterface $logger
    ){
    }

    #[Route('/{user}/{bookVersion}', name:'reservation_email')]
    #[IsGranted('ROLE_LIBRARIAN')]
    public function sendReservationEmail(User $user, BookVersion $bookVersion, MailerInterface $mailer): Response
    {
        try {
            $email = (new Email())
                ->from('no-reply@library.com')
                ->to($user->getEmail())
                ->subject('The book you have reserved is available to borrow !')
                ->html('
                <h4>Hello '. $user->getuserFirstName() .'</h4>
                <p>The book you have reserved (' . $bookVersion->getBook()->getName() . ') is available to borrow !</p>
                <a href="https://localhost/borrowing/new/'. $bookVersion->getId() .'">Click here to borrow</a>
            ');

            $mailer->send($email);
        } catch (TransportException $e) {
            $this->logger->error($e->getMessage());
        }

        return $this->redirectToRoute('app_borrowing_index', [], Response::HTTP_SEE_OTHER);
    }

    public function sendMail(MailerInterface $mailer): Response
    {$email = (new Email())
        ->from('no-reply@library.com')
        ->to('test@test.com')
        ->subject('The book you have reserved is available to borrow !')
        ->html('
                <h4>Hello, this is a test from cron</h4>
            ');

        $mailer->send($email);

        return new Response(Response::HTTP_OK);
    }
}
