<?php

namespace App\Mail;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SubscriptionRenewedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Invoice $invoice,
        public readonly User    $user
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Mawid Subscription Has Been Renewed – ' . $this->invoice->invoice_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.subscription-renewed',
            with: [
                'invoice'    => $this->invoice,
                'user'       => $this->user,
                'billingUrl' => route('admin.billing.index'),
            ],
        );
    }

    public function attachments(): array
    {
        // Attach a PDF of the invoice if DomPDF is installed
        if (!class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            return [];
        }

        try {
            $html    = view('admin.billing.invoice-pdf', ['invoice' => $this->invoice])->render();
            $pdf     = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)->setPaper('a4', 'portrait');
            $content = $pdf->output();

            return [
                Attachment::fromData(
                    fn () => $content,
                    'invoice-' . $this->invoice->invoice_number . '.pdf'
                )->withMime('application/pdf'),
            ];
        } catch (\Throwable $e) {
            Log::warning('SubscriptionRenewedMail: Could not generate PDF attachment', [
                'invoice' => $this->invoice->invoice_number,
                'error'   => $e->getMessage(),
            ]);
            return [];
        }
    }
}
