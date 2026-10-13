<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationCancelled extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Reservation $reservation,
        public string $emailLocale
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailLocale === 'fr'
                ? 'Annulation de réservation'
                : 'Reservation Cancellation',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation-cancelled',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}