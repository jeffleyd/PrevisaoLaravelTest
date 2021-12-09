<?php

namespace App\Notifications\Weather;

use App\Services\Api\Weather\Weather;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewsletterUser extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $data = (new Weather($notifiable->last_ip))->get();
        return (new MailMessage)
                    ->line('Olá '. $notifiable->name)
                    ->line('O clima em '.$data->location)
                    ->line('Temperatura atual é de '.$data->the_temp)
                    ->line('O tempo está '.strtolower($data->weather))
                    ->line('Temos uma probabilidade sobre o tempo de '.$data->predictability.'%')
                    ->line('Fique por dentro do tempo todos os dias.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
