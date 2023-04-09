<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\User;
use App\Models\Checklist;
use App\Hydraulics\ZohoInvoice;
use App\Hydraulics\ImageMagic;
use Exception;
use Illuminate\Support\Facades\Storage;
use DB;


use Illuminate\Support\Facades\Log;

class CampaignController extends Controller
{

    public static function imageCreate(Request $request, $name) {
        Log::debug('Inside imageCreate and the name is - yes this is being called dynamically: '.$name);
        $current = $request->input('campaign_mms');
        $result = ImageMagic::createImage($current, $name);
        $silly = $request->input('Alternate');  
        return response()->json([
            'Imagename' => $result,
            'mms_image' => $current
        ]);
    }

    public static function directImageCreate($current, $name) {
        Log::debug('Inside imageCreate and the name is - yes this is being called dynamically: '.$name);
        //$current = $request->input('campaign_mms');
        $result = ImageMagic::createImage($current, $name);
        Log::debug("The result I get back from ImageMagic is: ".$result);
        return $result;
        /*return response()->json([
            'Imagename' => $result,
            'mms_image' => $current
        ]);*/
    }

    public function vsl($perma) {

        $campaign = Campaign::where('permalink', $perma)->first();
        $url = $campaign->tiktok_url;
        $parts = parse_url($url);
        parse_str($parts['query'], $query);

        return view('vsl-single', ['campaign' => $campaign, 'youtube_v' => $query['v']]);

    }

    public function landing($category, $permalink) {

        $campaign = Campaign::where('permalink', $permalink)->where('category', $category)->first();
        $landing_view = $campaign->template_view;
        return view($landing_view, compact('campaign'));
    }

    public function prop_landing($compa_perma, $category, $slug) {



        $user = User::where('company_permalink', $compa_perma)->first();

        

        $campaign = Campaign::where('permalink', $slug)->where('author_id', $user->id)->first();
        

        $landing_view = $campaign->template_view;
        return view($landing_view, compact('campaign'));
    }

    public function single($compa_perma) {

        

        $user = User::where('company_permalink', $compa_perma)->first();

        //$campaigns = Campaign::where('author_id', $user->id)->get();
        $campaigns = Campaign::where('author_id', 33)->where('template', 0)->get();

        $hero_image = Storage::disk('s3')->url($user->hero_image);
        $profile_image = Storage::disk('s3')->url($user->profile_image);
        $logo_url = Storage::disk('s3')->url($user->company_logo);

        // Get first name
        $name = trim($user->name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim( preg_replace('#'.preg_quote($last_name,'#').'#', '', $name ) );

        if($user) {
        return view('landing-bdm', [
            'permalink' => $user->company_permalink,
            'user' => $user,
            'hero_image' => $hero_image,
            'profile_image' => $profile_image,
            'campaigns' => $campaigns,
            'fname' => $first_name,
            'logo_url' => $logo_url

        ]);
        }
    }

    

    public function appit($id, $set) {

        $check = Checklist::where('id', $id)->first();
        $check->approved = $set;
        $check->save();

    }

    public function singlestaging($compa_perma) {

        $user = User::where('company_permalink', $compa_perma)->first();

        $campaigns = Campaign::where('author_id', $user->id)->get();

        $hero_image = Storage::disk('s3')->url($user->hero_image);
        $profile_image = Storage::disk('s3')->url($user->profile_image);
        $logo_url = Storage::disk('s3')->url($user->company_logo);

        // Get first name
        $name = trim($user->name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim( preg_replace('#'.preg_quote($last_name,'#').'#', '', $name ) );

        if($user) {
        return view('landing-bdm-staging', [
            'permalink' => $user->company_permalink,
            'user' => $user,
            'hero_image' => $hero_image,
            'profile_image' => $profile_image,
            'campaigns' => $campaigns,
            'fname' => $first_name,
            'logo_url' => $logo_url

        ]);
        }
    }

    public function show($compa_perma, $slug)///"rental-property-network"
    {

        $user = User::where('company_permalink', $compa_perma)->first();
        $user_id = $user->id;

        $camp = Campaign::where('permalink', $slug)->where('author_id', $user_id)->first();
        $campaign = Campaign::where('id', $camp->id)->first();
       //$user = $campaign->author()->first();
        
        if ($camp && $compa_perma==$user->company_permalink) {

            //$invoice = new ZohoInvoice();
            $logo_url = Storage::disk('s3')->url($user->company_logo);
            if(isset($user->favicon_url)) {
            $favicon_url = Storage::disk('s3')->url($user->favicon_url);
            } else {
                $favicon_url = '/images/favicon-32x32.png';
            }
            if(isset($user->website_url)) {
                $site_url = $user->website_url;
            } else {
                $site_url = '#';
            }

            if(!empty($camp->video_thumbnail)) {
                $thumbnail = Storage::url($camp->video_thumbnail);
            } else {
                $thumbnail = '';
            }

            $view = $camp->template_view ?? 'campaign-single';

            return view($view, [
                'camp' => $camp,
                'user' => $user,
                'logo_url' => $logo_url,
                'thumbnail' => $thumbnail,
                'favicon_url' => $favicon_url,
                'site_url' => $site_url
                //'invoice' => $invoice
                
            ]);
        }

        // No match was found
        abort(404);
    }

    public static function grow() {
        $number = ImageMagic::return32();
        return 'Go go go! Number is: '.$number;
    }

    public static function createImage($name) {
        return "Name is: ".$name;
    }
}
