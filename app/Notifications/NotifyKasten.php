<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotifyKasten extends Notification
{
    use Queueable;
    public $DatosGlobales;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Array $datos)
    {
        $this->DatosGlobales = $datos;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    //Aqui se agrega el metodo por el cual se enviara la notificacion por ejemplo database inserta el registro en la bs y broadcast lo envia por pusher
    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

    public function toDatabase($notifiable){
        return [
            'datos' => $this->DatosGlobales 
        ];
    }

    public function toBroadcast($notifiable){
        return [
            'data'=>[
                'datos' => $this->DatosGlobales 
            ]
        ];
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
            //
        ];
    }
}
