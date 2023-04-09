<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class OppEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    public $guarantee;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
        $this->guarantee = Storage::disk('s3')->url('pdf/Your_Guarantee.pdf');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $pdf = Pdf::loadView('pdf.agreement');
        // or are we dancers
        if(isset($this->details['image'])) {
        
        return $this->subject('Your Personalized Rent Roll Growth Agreement')->view('emails.oppsEmail')->attach($this->details['image'])->attach($this->details['guarantee'])->attach($this->details['invoice'])->from('kosta@headstudios.com.au', 'Kosta Kondratenko'); // invoice invoice
        //return $this->subject('Your Personalized Rent Roll Growth Agreement')->view('emails.oppsEmail')->attach($this->details['image'])->attach($this->details['guarantee']);

        } else {

            return $this->subject($this->details['subject'])->view('emails.oppsEmail')->from('kosta@headstudios.com.au', 'Kosta Kondratenko') ->attachData($pdf->output(), 'mypdf.pdf', [
                'mime' => 'application/pdf',
            ])->attach($this->guarantee);

        }

    }
}
