<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TravelIntent extends Notification
{
    use Queueable;

    private $travelIntent;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($travelIntent)
    {
        //
        $this->travelIntent = $travelIntent;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'originFormattedAddress' => $this->travelIntent->getOriginFormattedAddress(),
            'originLongitude' => $this->travelIntent->getOriginLongitude(),
            'originLatitude' => $this->travelIntent->getOriginLatitude(),
            'destinationFormattedAddress' => $this->travelIntent->getDestinationFormattedAddress(),
            'destinationLongitude' => $this->travelIntent->getDestinationLongitude(),
            'destinationLatitude' => $this->travelIntent->getDestinationLatitude(),
            "distance" => $this->travelIntent->getDistance(),
            "duration" => $this->travelIntent->getDuration(),
            "durationText" => $this->travelIntent->getDurationText()
        ];
    }
}
