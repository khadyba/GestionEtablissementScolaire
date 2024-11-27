<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProfessorAssignedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $classeName;
    public $etablissementName;

    /**
     * Create a new message instance.
     *
     * @param string $classeName
     * @param string $etablissementName
     * @return void
     */
    public function __construct($classeName, $etablissementName)
    {
        $this->classeName = $classeName;
        $this->etablissementName = $etablissementName;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Notification d\'affectation de professeur',
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Notification d\'affectation de professeur')
                    ->view('email.profmail-assigned')
                    ->with([
                        'classeName' => '',
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
