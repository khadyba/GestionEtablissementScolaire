<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BulletinMail extends Mailable
{
    use Queueable, SerializesModels;

    public $eleve;
    public $classe;

    public function __construct($eleve, $classe)
    {
        $this->eleve = $eleve;
        $this->classe = $classe;
    }

    public function build()
    {
        $bulletinUrl = route('classes.bulletin', [$this->classe->id, $this->eleve->id]);

        return $this->subject('Bulletin Disponible')
                    ->markdown('email.bulletin')
                    ->with([
                        'eleve' => $this->eleve,
                        'classe' => $this->classe,
                        'bulletinUrl' => $bulletinUrl,
                    ]);
    }
}
