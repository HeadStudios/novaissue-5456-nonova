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

class GenerateVideoSeries implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    

    /**
     * Create a new job instance.
     *
     * @return void
     */

     public $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        

        $user_id = $this->user_id;
        $user = User::where('id', $user_id)->first();


        $permalink = $user->company_name;
        $permalink = strtolower($permalink);
        $permalink = str_replace(' ', '-', $permalink);

        $logo_path = $user->company_logo;
        
        
        $hero_path = $user->hero_image;
        $profile_photo_path = $user->profile_image;

        $logo_url = Storage::disk('s3')->url($logo_path);

        $templates = Campaign::where('template', 1)->get();

        
        


                foreach($templates as $template) {

                    

                    $proppas = $template->getPropsCollection();
                    $newone = $template->replicate();
                    $newone->author_id = $user_id;
                    $newone->save();

                    

                    foreach($proppas as $prop) {
                        $property = $prop->attributes->property;
                        $property = str_replace('{{logo_url}}', $logo_url, $property);
                        $property = str_replace('{{website_url}}', $user->website_url, $property);
                        $property = str_replace('{{mobile}}', $user->mobile, $property);
                        $property = str_replace('{{company_name}}', $user->company_name, $property);
                        $prop->attributes->property = $property;
                
                    }
                    
                    $newhawk = Campaign::where('id', $newone->id)->first();
                    $newhawk->setPropsCollection($proppas);
                    $newhawk->author_id = $user_id;
                    $newhawk->template = 0;

                    $copy = $newhawk->copy;
                    $copy = str_replace('{{company_name}}', $user->company_name, $copy);
                    $newhawk->copy = $copy;
                    $newhawk->video_thumbnail = '';

                    $newhawk->template_view = 'single.vsl-pm';
                    $newhawk->category = 'property-management';
                    

                    $newhawk->save();

                    


                }
        

    }
}
