<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Mail;

class ContactForm extends Component
{
    public $name;
    public $email;
    public $comment;
    public $phone;
    public $success;
    public $current_url;
    protected $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'comment' => 'required|min:5',
    ];

    public function mount() {
        $this->current_url = url()->current();
    }

    public function contactFormSubmit()
    {
        $contact = $this->validate();
        

        Mail::send('email',
        array(
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'comment' => $this->comment,
            'uri' => $this->current_url

            ),
            function($message){
                $message->from('kosta@headstudios.com.au');
                $message->to('enquiries@headstudios.com.au', 'Bobby')->subject('Your Site Contect Form');
            }
        );

        $this->success = 'Thank you for reaching out to us!';

        $this->clearFields();
    }

    private function clearFields()
    {
        $this->name = '';
        $this->email = '';
        $this->comment = '';
        $this->phone = '';
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}