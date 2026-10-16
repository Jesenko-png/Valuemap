<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class ConfirmNewsletterSubscription extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $confirmUrl = URL::temporarySignedRoute('newsletter.confirm', now()->addHours(48), ['subscriber' => $notifiable]);
        $unsubscribeUrl = URL::signedRoute('newsletter.unsubscribe', ['subscriber' => $notifiable]);

        return (new MailMessage)
            ->subject('Confirm your VALUEMAP newsletter subscription')
            ->greeting('Confirm your subscription')
            ->line('You requested VALUEMAP project updates for '.$notifiable->email.'.')
            ->action('Confirm subscription', $confirmUrl)
            ->line('This confirmation link expires in 48 hours.')
            ->line('If you did not request this, no action is needed. You can also cancel the pending request here:')
            ->line($unsubscribeUrl);
    }
}
