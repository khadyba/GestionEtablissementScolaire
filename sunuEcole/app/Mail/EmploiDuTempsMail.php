<?php

namespace App\Mail;

use App\Models\Eleve;
use App\Models\Eleves;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmploiDuTempsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $eleve;

    public function __construct(Eleves $eleve)
    {
        $this->eleve = $eleve;
    }

    public function build()
    {
        return $this->view('email.emploi_du_temps')
                    ->subject('Emploi du Temps de votre enfant')
                    ->with(['eleve' => $this->eleve]);
    }
}
