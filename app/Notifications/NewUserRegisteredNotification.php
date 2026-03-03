<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Business;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewUserRegisteredNotification extends Notification
{
    use Queueable;

    public function __construct(
        public readonly User     $user,
        public readonly Business $business
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = route('admin.super.users.show', $this->user);

        return (new MailMessage)
            ->subject('🆕 New User Registered — ' . config('app.name'))
            ->view('emails.super-admin.new-user', [
                'user'     => $this->user,
                'business' => $this->business,
                'url'      => $url,
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'          => 'new_user',
            'user_id'       => $this->user->id,
            'user_name'     => $this->user->name,
            'user_email'    => $this->user->email,
            'business_name' => $this->business->name,
            'business_slug' => $this->business->slug,
            'message'       => "New user registered: {$this->user->name} ({$this->user->email})",
        ];
    }
}
