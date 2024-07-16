<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProfessorDetachedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $classeNom;
    public $etablissementName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($classeNom, $etablissementName)
    {
        $this->classeNom = $classeNom;
        $this->etablissementName = $etablissementName;
    }

    public function build()
    {
        return $this->subject('Notification de retrait de classe')
                    ->view('email.professor_detached')
                    ->with([
                        'classeNom' => $this->classeNom,
                        'etablissementName' => $this->etablissementName,
                    ]);
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
