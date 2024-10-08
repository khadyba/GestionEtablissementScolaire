<?php

namespace App\Mail;

use App\Models\Eleves;
use App\Models\Etablissement;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentReceived extends Mailable
{
    use Queueable, SerializesModels;
    public $eleve;
    public $montant;
    public   $etablissement;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    
     public function __construct(Eleves $eleve, $montant, Etablissement $etablissement)
     {
         $this->eleve = $eleve;
         $this->montant = $montant;
         $this->etablissement = $etablissement;
     }


     public function build()
     {
         return $this->view('payment_recu')
         ->subject('Paiement reçu')
         ->with([
             'eleveNom' => $this->eleve->nom,
             'elevePrenoms' => $this->eleve->prenoms,
             'montant' => $this->montant,
             'etablissementNom' => $this->etablissement->nom,
            ]);
            dd( $this->etablissement->nom);
        }
    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Payment Received',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'email.payment_reçu',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
