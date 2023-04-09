<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use \App\Models\Contact;

class SendPortalSubscribe implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $subscribers;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($subscribers)
    {
        $this->subscribers = $subscribers;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $records = $this->subscribers;
        ///
        foreach ($records as $record) {

        
            // Check if the record has a 'phone' field
            if (isset($record->fields->First) && isset($record->fields->Email)) {
                
                
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer '.env('SENDPORTAL_API_KEY'),
                ])->post('https://mail.rrdevours.monster/api/v1/subscribers', [
                    'first_name' => $record->fields->First,
                    'email' => $record->fields->Email,
                ]);
                
                
            }
        }
    }
}
