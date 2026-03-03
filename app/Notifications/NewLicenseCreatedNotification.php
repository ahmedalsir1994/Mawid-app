<?php

namespace App\Notifications;

use App\Models\License;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewLicenseCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(public readonly License $license) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = route('admin.super.licenses.show', $this->license);

        return (new MailMessage)
            ->subject('🔑 New License Created — ' . config('app.name'))
            ->view('emails.super-admin.new-license', [
                'license'  => $this->license,
                'business' => $this->license->business,
                'url'      => $url,
            ]);
    }

    public function toArray(object $notifiable): array
    {
        $plan = ucfirst($this->license->plan ?? 'free');
        return [
            'type'          => 'new_license',
            'license_id'    => $this->license->id,
            'license_key'   => $this->license->license_key,
            'plan'          => $this->license->plan,
            'business_name' => $this->license->business->name ?? '—',
            'business_slug' => $this->license->business->slug ?? '',
            'message'       => "New {$plan} license created for: " . ($this->license->business->name ?? '—'),
        ];
    }
}
