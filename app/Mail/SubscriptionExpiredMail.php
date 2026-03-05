<?php

namespace App\Mail;

use App\Models\License;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionExpiredMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User    $admin,
        public License $license,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your subscription has expired — your data is safe',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.subscription-expired',
        );
    }
}
