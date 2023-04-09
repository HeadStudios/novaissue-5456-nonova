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

class SmileAndWaveRemote implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $contact;
    public $campaign;
    public $mms_image;
    public $cta;

    public function __construct(Contact $contact, Campaign $model)
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
        
        $contact = $this->contact;
        $model = $this->campaign;

        $name = str_replace(' ', '_', $contact->name);
        $name = strtok($contact->name, " ");

        $mms = CampaignController::directImageCreate($model->mms_image, $name); //$array['Imagename'];

        $url = $model->cta_link.'?fname='.$name;

        $path = str_replace("{{name}}", $name, $model->shortlink_path);
        $path = $path.rand(0,1000);
        

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'sk_7D26vBocMbHyPvUL'
        ])->post('https://api.short.io/links', [
            'allowDuplicates' => true,
            'domain' => 'showme.headstudios.com.au',
            'originalURL' => $url,
            'path' => $path.rand(0,1000)
        ]);


        $shortUrl = $response['shortURL'];

        
        //$shortUrl = 'noidea.com.au/never';

        

        //$model->campaign_ready = true;
        $mms_msg = str_replace("{name}",$contact->name,$model->mms_msg);
        $mms_msg = str_replace("{link}",$shortUrl,$mms_msg);
        $mms_msg = $mms_msg.'
P.S. To never hear from me again simply reply with STOP and I will leave you alone for eternity.';
        //$model->save();

        $contact_id = $contact->id;
        $campaign_id = $model->id;

        $insert_valves = array('shortUrl' => $shortUrl, 'contacts_id' => $contact_id, 'campaign_id' => $campaign_id, 'mms_image' => $mms, 'mms_message' => $mms_msg);
        

        $inserter = DB::table('campaign_contacts')->insert([
            'shortlink' => $shortUrl,
            'clicks' => '0',
            'contacts_id' => $contact_id,
            'campaign_id' => $campaign_id,
            'mms_image' => $mms,
            'mms_msg' => $mms_msg
        ]);

        

    }
}
