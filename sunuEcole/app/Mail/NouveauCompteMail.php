<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NouveauCompteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $identifiants;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($identifiants)
    {
        $this->identifiants = $identifiants;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Votre compte sur SunuLycée')->view('email.professeur_compte', [
            'email' => $this->identifiants['email'],
            'password' => $this->identifiants['password'],
        ]);
    }
}


