<?php

namespace App\Notifications;

use App\Models\License;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AutoRenewFailedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly License $license,
        public readonly string  $reason = 'Payment declined'
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $plan    = ucfirst($this->license->plan ?? 'Pro');
        $attempt = $this->license->auto_renew_attempts ?? 1;

        return (new MailMessage)
            ->subject('⚠️ Auto-renewal Failed — Action Required')
            ->markdown('emails.auto-renew-failed', [
                'notifiable' => $notifiable,
                'license'    => $this->license,
                'reason'     => $this->reason,
                'plan'       => $plan,
                'attempt'    => $attempt,
                'billingUrl' => route('admin.billing.index'),
            ]);
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'       => 'auto_renew_failed',
            'message'    => 'Your subscription auto-renewal failed. Please update your payment method.',
            'reason'     => $this->reason,
            'attempt'    => $this->license->auto_renew_attempts ?? 1,
            'license_id' => $this->license->id,
            'plan'       => $this->license->plan,
            'url'        => route('admin.billing.index'),
        ];
    }
}
