<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Contact;
use App\Models\CampaignContact;

class CampaignCreationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $contacts = Contact::where(function ($query) {
            $query->where('unsubscribed', 0)
            ->orWhereNull('unsubscribed');
            })
            ->inRandomOrder()
            ->limit(15)
            ->get();
          
            $fields = array('left' => 10, 'top' => 10, 'size' => 24);
      
            $campaign_id = 306;
      
            foreach($contacts as $contact) {

                
      
            $camp = CampaignContact::firstOrCreate([
              'campaign_id' => $campaign_id,
              'contacts_id' => $contact->id,
              'action_fields' => $fields
              ]);

            }
    }
}