<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RecoveryPasswordNotify extends Notification
{
    use Queueable;

    private string $url;
    private string $token;
    /**
     * Create a new notification instance.
     */
    public function __construct(string $url, string $token)
    {
        $this->url      = $url;
        $this->token    = $token;
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
            ->subject('Сброс пароля')
            ->line('Пожалуйста, нажмите на кнопку, чтобы сбросить свой пароль.')
            ->action('url: ', $this->recoveryPasswordUrl())
            ->line('Благодарим вас за использование нашего приложения!');
    }

    protected function recoveryPasswordUrl(): string
    {
        return $this->url . '/' . $this->token;
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
        ];
    }
}
