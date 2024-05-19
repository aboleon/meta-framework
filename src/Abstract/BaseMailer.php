<?php

namespace MetaFramework\Abstract;
use MetaFramework\Interfaces\Mailer as MailerInterface;
use App\Mail\MailerMail;
use Illuminate\Support\Facades\Mail;

abstract class BaseMailer implements MailerInterface
{
    public function send()
    {
        return Mail::send(new MailerMail($this));
    }
}