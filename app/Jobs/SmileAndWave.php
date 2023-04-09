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

class SmileAndWave implements ShouldQueue
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

    public function __construct($contact, $model, $number)
    {
        $this->contact = $contact;
        $this->campaign = $model;
        $this->number = $number;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        //

        $contact_id = $this->contact;
        $model_id = $this->campaign;

        $contact = Contact::where('id', $contact_id)->first();
        $campaign = Campaign::where('id', $model_id)->first();

        $contact_id = $contact->id;
        $campaign_id = $campaign->id;

        
        $name = str_replace(' ', '_', $contact->name);
        $name = strtok($contact->name, " ");

        if($this->number == 0) {
        $mms = CampaignController::directImageCreate($campaign->mms_image, $name); //$array['Imagename'];
        }


        $user = User::where('id', $campaign->author_id)->first();
        $url = env('APP_URL').'/vblog/'.$user->company_permalink.'/'.$campaign->permalink.'?fname='.$name;


//        $url = $campaign->cta_link.'?fname='.$name;

        $path = str_replace("{{name}}", $name, $campaign->shortlink_path);
        $path = rand(0,10).'-'.$path;

        
        

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'sk_7D26vBocMbHyPvUL'
        ])->post('https://api.short.io/links', [
            'allowDuplicates' => true,
            'domain' => 'showme.headstudios.com.au',
            'originalURL' => $url,
            'path' => $path
        ]);

        // Until I get another url shortening service
        $shortUrl = 'https://showme.headstudios.com.au/'.$path;

        

        

        $message = str_replace('{{name}}', $name, $campaign->mms_msg);
        //$message = str_replace('{{company_name}}', $user->company_name, $message);
        $message = str_replace('{{link}}', $shortUrl, $message);
        $message = $message.'
P.S. To never hear from me again simply reply with STOP and I will leave you alone for eternity.';

        

        if($this->number == 0) {
        $resulter = CampaignContact::updateOrCreate(['contacts_id' => $contact_id, 'campaign_id' => $campaign_id],
            ['mms_msg' => $message, 'mms_image' => $mms, 'clicks' => '0', 'shortlink' => $shortUrl]);
        } else {
            $resulter = CampaignContact::updateOrCreate(['contacts_id' => $contact_id, 'campaign_id' => $campaign_id],
            ['mms_msg' => $message, 'clicks' => '0', 'shortlink' => $shortUrl]);
        }

        
        
        
        

    }
}
