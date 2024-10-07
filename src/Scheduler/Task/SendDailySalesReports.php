<?php

namespace App\Scheduler\Task;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Scheduler\Attribute\AsCronTask;
use Symfony\Component\Scheduler\Attribute\AsPeriodicTask;


class SendDailySalesReports
{
    #[AsCronTask('* * * * *')]
    public function sendEmail(MailerInterface $mailer): void
    {
        $email = (new Email())
            ->from('no-reply@library.com')
            ->to('test@test.com')
            ->subject('The book you have reserved is available to borrow !')
            ->html('
                    <h4>Hello, this is a test from cron</h4>
                ')
        ;

        $mailer->send($email);
    }
}
