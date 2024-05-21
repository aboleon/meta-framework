<?php

namespace App\Notifications;

use App\Mail\PasswordForgotten;
use Illuminate\Auth\Notifications\ResetPassword;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toMail($notifiable)
    {
        $resetUrl = $this->resetUrl($notifiable);

        return (new PasswordForgotten($notifiable->getEmailForPasswordReset(),$resetUrl));
    }


}
