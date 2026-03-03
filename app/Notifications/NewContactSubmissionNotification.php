<?php

namespace App\Notifications;

use App\Models\ContactSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewContactSubmissionNotification extends Notification
{
    use Queueable;

    public function __construct(public readonly ContactSubmission $submission) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'       => 'contact_submission',
            'id'         => $this->submission->id,
            'name'       => $this->submission->name,
            'email'      => $this->submission->email,
            'phone'      => $this->submission->phone,
            'subject'    => $this->submission->subject,
            'message_preview' => \Illuminate\Support\Str::limit($this->submission->message, 80),
            'created_at' => $this->submission->created_at->toDateTimeString(),
            'message'    => "New contact message from {$this->submission->name}: " . \Illuminate\Support\Str::limit($this->submission->message, 60),
        ];
    }
}
