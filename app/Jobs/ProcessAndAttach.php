<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use App\Hydraulics\SMSPrep;

use App\Models\CampaignContact;
use App\Models\Campaign;
use App\Models\Contact;

use Laravel\Nova\Fields\ActionFields;

class ProcessAndAttach implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $campcontact;
    public $fields;
    public $campaign;
    public $contact;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Campaign $campaign, Contact $contact, ActionFields $fields)
    {
        //$this->campcontact = $campcontact;
        $this->campaign = $campaign;
        $this->contact = $contact;
        $this->fields = $fields;
    }

    /*public function middleware()
{
    return [new WithoutOverlapping('bee')];
}*/

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $campaign = $this->campaign;
        $contact = $this->contact;
        $fields = $this->fields;
        //$prepper = new SMSPrep;
        //$mms = $campaign->mms_msg;
        //$mms = $prepper->formatSMS($mms, $contact, $campaign);

        $camp = CampaignContact::firstOrCreate([
            'campaign_id' => $campaign->id,
            'contacts_id' => $contact->id
            ]);

    
        
        //
        //
        //$camp->drawMMS($fields->left_x, $fields->top_x, $fields->font_size);
        //
    }
}
