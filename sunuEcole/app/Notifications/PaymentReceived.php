<?php

namespace App\Notifications;


use Illuminate\Queue\SerializesModels;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentReceived extends Mailable
{
    use Queueable;

    protected $eleve;
    protected $montant;

    public function __construct($eleve, $montant)
    {
        $this->eleve = $eleve;
        $this->montant = $montant;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function build()
    {
        return $this->view('emails.payment_received')
                    ->subject('Paiement reçu')
                    ->with([
                        'eleveNom' => $this->eleve->nom,
                        'elevePrenoms' => $this->eleve->prenoms,
                        'montant' => $this->montant,
                    ]);
    }
}
