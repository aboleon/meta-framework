<?php

namespace App\Notifications;

use Aboleon\MetaFramework\Interfaces\UserInterface;
use App\Mail\Welcome;
use Aboleon\MetaFramework\Traits\Responses;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendWelcomeNotification
{
    use Responses;


    public function __construct(
        public Authenticatable|UserInterface $user
    )
    {
    }

    public function __invoke(): array
    {

        try {
            Mail::to($this->user->email)->send(new Welcome($this->user));
        } catch (Throwable $e) {
            $this->responseException($e);
            report($e);
        }

        return $this->fetchResponse();
    }
}
