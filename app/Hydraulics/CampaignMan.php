<?php

namespace App\Hydraulics;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Models\Opps;
use App\Hydraulics\AirBooker;
use App\Hydraulics\Syncer;
use App\Hydraulics\CampaignProvider;
use App\Models\User;
use App\Models\Campaign;
use App\Models\Contact;
use App\Jobs\SendAPacket;
use App\Models\Checklist;
use App\Models\Vlesson;
use \TANIOS\Airtable\Airtable;
use Illuminate\Support\Carbon;
use GuzzleHttp\Client;



class CampaignMan {

    protected $camper;

    public function __construct(CampaignProvider $camper) {

        $this->camper = $camper;

    }

    public function createThumb($url) {
        return $this->camper->createThumbnail($url);
    }

    public function oppHit($model, $email = null, $fields = null) {
        return $this->camper->createOppFromModel($model, $email, $fields);
    }

    public function vmclear() {
        $this->camper->updateVoicemails();
    }

    public function screenshotModel($model) {

        if($model instanceof App\Models\VideoAudit) {
        $screenshot_url = $this->camper->takeScreenshot($model, 1440, 1500);
        
        } else {

        $screenshot_url = $this->camper->takeScreenshot($model, 1440, 1500);
        

        }
        
        
    }

    public function ffmpeg($ffmpeg) {
        return $this->camper->ffmpeg($ffmpeg);
    }

    public function json_dumper($campaign) {
        return $this->camper->createJson($campaign);
    }

    public function getTimezone($city) {
        return $this->camper->getTimezoneByCityName($city);
    }

    



}