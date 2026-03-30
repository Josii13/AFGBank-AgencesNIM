<?php

namespace App\Mail;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeadSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Lead $lead) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle demande AFG Bank – ' . $this->lead->nom_prenoms,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.lead-submitted',
        );
    }
}
