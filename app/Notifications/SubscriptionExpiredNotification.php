<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Subscription;


class SubscriptionExpiredNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(Subscription $subscription)
    {
        //
        $this->subscription = $subscription;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('انتهاء الاشتراك')
        ->greeting('مرحبا ' . $notifiable->name)
        ->line("اشتراكك في باقة {$this->subscription->plan->name} قد انتهى بتاريخ {$this->subscription->end_date->format('Y-m-d')}.")
        ->action('تجديد الاشتراك', url('/subscriptions'))
        ->line('شكراً لاستخدامك نظامنا.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
            'subscription_id' => $this->subscription->id,
            'plan' => $this->subscription->plan->name,
            'endDate' => $this->subscription->plan->endDate,
        ];
    }
}
