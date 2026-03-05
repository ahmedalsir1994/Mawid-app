<?php

namespace App\Mail;

use App\Models\License;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentFailedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly User    $user,
        public readonly License $license,
        public readonly string  $reason = 'Your card was declined.'
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⚠️ Payment Failed — Action Required to Keep Your Mawid Subscription',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.payment-failed',
            with: [
                'user'              => $this->user,
                'license'           => $this->license,
                'reason'            => $this->reason,
                'graceDaysLeft'     => $this->license->graceDaysRemaining(),
                'graceEndsAt'       => $this->license->grace_period_ends_at,
                'updateCardUrl'     => route('admin.billing.index'),
                'billingUrl'        => route('admin.billing.index'),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
