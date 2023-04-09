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

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $campaign_id;
    protected $contact_id;
    protected $fields;

    public $id;
    public function __construct($campaign_id, $contact_id, $fields)
    {
        $this->campaign_id = $campaign_id;
        $this->contact_id = $contact_id;
        $this->fields = $fields;
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        
        $arra = $this->fields;
        
        
        $camp = CampaignContact::firstOrCreate([
            'campaign_id' => $this->campaign_id,
            'contacts_id' => $this->contact_id,
            'action_fields' => $arra
            ]);
    }
}
