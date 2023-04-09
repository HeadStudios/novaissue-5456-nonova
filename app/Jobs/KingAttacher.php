<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

use App\Models\Contact;
use App\Models\User;
use App\Models\Campaign;
use App\Models\CampaignContact;
use App\Jobs\ProcessLinkmeister;
use App\Http\Controllers\CampaignController;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;

use App\Hydraulics\ImageMagic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class KingAttacher implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $deleteWhenMissingModels = true;

    public $contact;
    public $campaign;
    public $number;
    public $mms_image;
    public $cta;

    public function __construct($contact, $model)
    {
        $this->contact = $contact;
        $this->campaign = $model;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        

        $contact_id = $this->contact;
        $model_id = $this->campaign;

        

        $contact = Contact::where('id', $contact_id)->first();
        $campaign = Campaign::where('id', $model_id)->first();

        

        $contact_id = $contact->id;
        $campaign_id = $campaign->id;

        $name = $contact->name;

        $message = str_replace('{{name}}', $name, $campaign->mms_msg);
        

        

        $resulter = CampaignContact::updateOrCreate(['contacts_id' => $contact_id, 'campaign_id' => $campaign_id],
            ['mms_msg' => $message, 'clicks' => '0']);
        
    }
}
