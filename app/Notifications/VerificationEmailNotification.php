<?php

namespace App\Notifications;

use App\Models\ECode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Random\RandomException;

class VerificationEmailNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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
            ->subject('Подтвердите свою почту')
            ->line("Код для верификации почты: " . $this->verificationCode($notifiable))
            ->line('Спасибо что используете на продукт!');
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

    /**
     * @throws RandomException
     */
    private function verificationCode($notifiable): int
    {
        $code = random_int(1000, 9999);
        $notifiable->ecode()->delete();
        $notifiable->ecode()->create([
            'code' => $code
        ]);
        return $code;
    }
}
