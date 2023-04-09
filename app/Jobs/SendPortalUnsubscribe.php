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

class SendPortalUnsubscribe implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $unsubscribed;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($unsubscribed)
    {
        $this->unsubscribed = $unsubscribed;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $contacts = Contact::all();
        $records = $this->unsubscribed;
        $cachedContacts = $contacts->keyBy('mobile');
        foreach ($records as $record) {

        
            // Check if the record has a 'phone' field
            if (isset($record->fields->phone)) {
                // Search for a Contact model with a matching phone number
                $contact = $cachedContacts->get(PhoneNumber::make($record->fields->phone, 'AU')->formatE164());

                // Check if a matching Contact was found
                if ($contact && ($contact->unsubscribed === null || $contact->unsubscribed == 0)) {
                    // Update the unsubscribe column of the Contact model
                    //$contact->update(['unsubscribe' => true]);
                    
                    
                    
                }

                if($contact && isset($contact->name) && isset($contact->email)) {
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer XF3p10FgZVJp6djsCKQx7MDvbft1E7CV',
                    ])->post('https://mail.rrdevours.monster/api/v1/subscribers', [
                        'first_name' => $contact->name,
                        'email' => $contact->email,
                        'unsubscribed_at' => '2020-03-24 10:43:08',
                    ]);
                } 
            }
        }
    }
}
