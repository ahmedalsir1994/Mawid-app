<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBookingNotification extends Notification
{
    use Queueable;

    public $booking;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'customer_name' => $this->booking->customer_name,
            'customer_phone' => $this->booking->customer_phone,
            'service_name' => $this->booking->service->name,
            'branch_name' => $this->booking->branch?->name,
            'booking_date' => $this->booking->booking_date,
            'start_time' => $this->booking->start_time,
            'reference_code' => $this->booking->reference_code,
            'message' => "New booking from {$this->booking->customer_name} for {$this->booking->service->name}",
        ];
    }
}
