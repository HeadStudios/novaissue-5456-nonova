<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\User;

class GenericMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $user;
    public $view;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $subject, $view)
    {
        $this->view = $view;
        $this->user = $user;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->subject($this->subject)
                    ->markdown($this->view);

    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->logo(asset('/plain-assets/logos/lion-head.png'))
                    ->markdown($this->view)
                    ->with('user', $this->user);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
