<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LionNotification extends Notification
{
    use Queueable;

    public $user;
    public $course;
    public $lessons;
    public $checklists;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user,$course, $lessons, $checklists)
    {
        $this->user = $user;
        $this->course = $course;
        
        $this->lessons = $lessons;
        $this->checklists = $checklists;
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
        ->markdown('emails.lessons-assigned', [
            'lessons' => $this->lessons,
            'user' => $this->user,
            'course' => $this->course,
            'checklists' => $this->checklists
        ]);
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
