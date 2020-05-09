<?php

namespace Flarumite\PostDecontaminator\Util;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Mail\Message;

class Emailer
{
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail(string $email, string $subject, string $body): void
    {
        $this->mailer->raw($body, function (Message $message) use ($email,  $subject) {
            $message->to($email);
            $message->subject($subject);
        });
    }
}
