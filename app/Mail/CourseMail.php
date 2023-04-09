<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Notifications\Messages\MailMessage;

class CourseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $lessons;
    public $user;
    public $course;
    public $checklists;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $course, $lessons, $checklists)
    {
        $this->lessons = $lessons;
        $this->user = $user;
        $this->course = $course;
        $this->checklists = $checklists;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->subject('You Have Lessons Assigned Build and Mail')
                    ->markdown('emails.lessons-assigned')
                    ->with('lessons', $this->lessons);

    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->logo(asset('/plain-assets/logos/lion-head.png'))
                    ->markdown('emails.lessons-assigned')
                    ->with('lessons', $this->lessons)
                    ->with('user', $this->user)
                    ->with('course', $this->course)
                    ->with('checklists', $this->checklists);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
