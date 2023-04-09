<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NowYouKnow extends Notification
{
    use Queueable;

    public $subject;
    public $headline;
    public $message;
    public $butt_txt;
    public $butt_link;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($subject,$headline, $message, $butt_text, $butt_link)
    {
        $this->subject = $subject;
        $this->headline = $headline;
        $this->message = $message;
        $this->butt_txt = $butt_text;
        $this->butt_link = $butt_link;
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
        
        
        return (new MailMessage)
        ->subject($this->subject)
        ->greeting($this->headline)
        ->line($this->message)
        ->action($this->butt_txt, $this->butt_link)
        ->salutation("Best regards,  \nRent Roll Devour Team");
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
