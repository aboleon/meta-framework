<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordForgotten extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        public string $email,
        public string $reset_url)
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //TODO: from('contact@ajconseils.com') Cached::settings renvoi une valeur RFC incompatible
        return $this
            ->to($this->email)
            ->from('contact@example.com')
            ->subject('Réinitialisation de votre mot de passe')
            ->view('mails.password-forgotten');
    }


}
