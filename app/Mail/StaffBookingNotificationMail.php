<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Business;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StaffBookingNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Booking $booking,
        public readonly Business $business,
        public readonly User $recipient
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Booking – ' . $this->booking->reference_code . ' · ' . $this->business->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.staff-booking-notification',
        );
    }
}
