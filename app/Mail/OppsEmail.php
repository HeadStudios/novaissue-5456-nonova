<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class OppsEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // or are we dancers

        $data = $this->details;
        
        
        $pdf = Pdf::loadView('pdf.agreement-live', compact('data'));
        $pdfContent = $pdf->output();

        $pdfTitle = 'Video Rent Roll Acceleration Agreement for '.$data['name'].' - '.date('d/m/Y').'.pdf';

        $name = $data['name'];


        if(isset($this->details['image'])) {

            

        //$data = json_decode(json_encode($this->details), false);
        
        
        
        
        return $this->subject('Your Personaliza Rent Roll Growth Agreement')->view('emails.oppsEmail', compact($data))->attach($this->details['guarantee'])->attach($this->details['invoice'])->attachData($pdfContent, 'shakashaka.pdf', [
                'mime' => 'application/pdf'
            ])->from('kosta@headstudios.com.au', 'Kosta Kondratenko'); // invoice invoice
        //return $this->subject('Your Personalized Rent Roll Growth Agreement')->view('emails.oppsEmail')->attach($this->details['image'])->attach($this->details['guarantee']);

        } else {

            
            return $this->subject('Your Personaliza Rent Roll Growth Agreement')->view('emails.oppsEmail')->attachData($pdfContent, $pdfTitle, [
                'mime' => 'application/pdf'
            ])->attach($data['guarantee'])->attach($data['invoice'])->from('kosta@headstudios.com.au', 'Kosta Kondratenko'); // invoice invoice

        }

    }
}
