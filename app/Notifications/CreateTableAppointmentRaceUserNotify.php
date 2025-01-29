<?php

namespace App\Notifications;

use App\Models\Race;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateTableAppointmentRaceUserNotify extends Notification
{
    use Queueable;

    private Race $race;
    private string $url;
    /**
     * Create a new notification instance.
     */
    public function __construct(string $url, Race $race)
    {
        $this->url = $url;
        $this->race = $race;
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
                    ->subject('Таблица участников сформирована')
                    ->line('Отлично!!! Таблица с участниками гонки "' .$this->race->name. '" сформирована, можете перейти к ней по кнопке ниже.')
                    ->action('Перейти к таблице', url($this->url))
                    ->line('Спасибо что используете нашим продуктом!');
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
