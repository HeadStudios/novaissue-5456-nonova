<?php

namespace App\Hydraulics;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Models\Opps;
use App\Models\User;
use App\Models\Campaign;
use App\Jobs\SendAPacket;
use App\Models\Checklist;
use App\Models\Vlesson;
use Illuminate\Support\Facades\Env;
use Illuminate\Support\Facades\Storage;
use DigitalOceanV2\Client as DigitalOceanClient;

class Campaigner {

    public static function Merger($field, $user_id) {

        

        $user = User::where('id', $user_id)->first();

        $logo_path = $user->company_logo;
        $logo_url = Storage::disk('s3')->url($logo_path);

        $field = str_replace('{{logo_url}}', $logo_url, $field);
        $field = str_replace('{{website_url}}', $user->website_url, $field);
        $field = str_replace('{{mobile}}', $user->mobile, $field);
        $field = str_replace('{{company_name}}', $user->company_name, $field);
        
        
        return $field;

    }

    public static function split_name($name) {
        $name = trim($name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim( preg_replace('#'.preg_quote($last_name,'#').'#', '', $name ) );
        return array($first_name, $last_name);
    }

    public static function courseStatus($vlesson_id) {

        $status = [];
        $approved = [];
        $checklist = Checklist::where('user_id', Auth::id())->where('vlessons_id', $vlesson_id)->get();
        foreach($checklist as $check) {
            $status[] = $check->status;
            $approved[] = $check->approved;
        }
    
    
            
    
        if(!in_array(0, $approved)) {
            return "Approved";    
        } elseif(!in_array(0, $status)) {
            return "Completed";
        } else {
            return "Todo";
        }
    
      }

      

    public static function getNextCourseUrl($lesson_id) {

        $completed = Vlesson::whereHas('checklist', function($query) {
            $query->where('status', 0)->where('user_id', Auth::id());
        })->where('id', '!=', $lesson_id)->orderBy('id', 'asc')->first();
        //return $completed;
        if(!$completed) { return "/dashboard"; } else { return self::getCourseUrl($completed->id); }
        
    }

    public static function searchJsonFields($json, $searchString) {
        $results = array();
      
        foreach ($json as $key => $value) {
          if (is_object($value) || is_array($value)) {
            $results = array_merge($results, self::searchJsonFields($value, $searchString));
          } else {
            if (strpos($value, $searchString) !== false) {
              $results[] = $key;
            }
          }
        }
      
        return $results;
      }
      

    

    public static function sequencer($user_id) {

        $details = [
       
            'name' => 'Aston',
            'body' => 'I wonder if this will be <b>bold</b>',
            'subject' => 'The Great awakening',
        ];
    
        \Mail::to('kostakondratenko77@yahoo.com')->cc('enquiries@headstudios.com.au')->later(now()->addMinutes(1), new \App\Mail\OppsEmail($details));
        SendAPacket::dispatch('61415932797', 'Sequence #1 - Your campaignis ready', '')->delay(now()->addMinutes(1));

        $details['body'] = "Sequence #2 and it's hip to be <b>squre!</b>";
        \Mail::to('kostakondratenko77@yahoo.com')->cc('enquiries@headstudios.com.au')->later(now()->addMinutes(2), new \App\Mail\OppsEmail($details));
        SendAPacket::dispatch('61415932797', 'Sequence #2 - Your campaignis ready again', '')->delay(now()->addMinutes(2));

        $details['body'] = "Sequence #3 and you still can't get a reservatio to <b>Dorsia</b>";
        \Mail::to('kostakondratenko77@yahoo.com')->cc('enquiries@headstudios.com.au')->later(now()->addMinutes(2), new \App\Mail\OppsEmail($details));
        SendAPacket::dispatch('61415932797', 'Sequence #3 - Your campaignis ready finally', '')->delay(now()->addMinutes(3));

    }

    public static function resizeToLg($droplet_id = '310466241') {
        $response = Http::withToken(env('DO_TOKEN'))
    ->post('https://api.digitalocean.com/v2/droplets/310466241/actions', [
        "type" => "resize",
        "disk" => false,
        "size" => "s-2vcpu-4gb-amd"
    ]);
    return $response;

}

public static function resizeToSm($droplet_id = '310466241') {
    $response = Http::withToken(env('DO_TOKEN'))
->post('https://api.digitalocean.com/v2/droplets/310466241/actions', [
    "type" => "resize",
    "disk" => false,
    "size" => "s-1vcpu-1gb-intel"
]);
return $response;
}

public static function upgradeServer($droplet_id = '310466241')
{
    $client = new DigitalOceanClient();
    $client->authenticate(env('DO_TOKEN'));
    $droplet = $client->droplet();

    $currentDroplet = $droplet->getById($droplet_id);
    $currentSize = $currentDroplet->sizeSlug;
    $currentStatus = $currentDroplet->status;

    if ($currentStatus !== 'off' && $currentSize === 's-2vcpu-4gb-amd') {
        return; // Do nothing, as the droplet is already in the desired state
    }

    $shutdown = $droplet->shutdown($droplet_id);
    $shutdownActionId = $shutdown->id;
    self::waitForActionCompletion($client, $droplet_id, $shutdownActionId);

    $resizeResponse = self::resizeToLg();
    $resizeActionId = $resizeResponse['action']['id'];
    self::waitForActionCompletion($client, $droplet_id, $resizeActionId);

    $powerOn = $droplet->powerOn($droplet_id);
    $powerOnActionId = $powerOn->id;
    self::waitForActionCompletion($client, $droplet_id, $powerOnActionId);
}

public static function downgradeServer($droplet_id = '310466241')
{
    $client = new DigitalOceanClient();
    $client->authenticate(env('DO_TOKEN'));
    $droplet = $client->droplet();

    $currentDroplet = $droplet->getById($droplet_id);
    $currentSize = $currentDroplet->sizeSlug;
    $currentStatus = $currentDroplet->status;

    if ($currentStatus !== 'off' && $currentSize === 's-1vcpu-1gb') {
        return; // Do nothing, as the droplet is already in the desired state
    }

    $shutdown = $droplet->shutdown($droplet_id);
    $shutdownActionId = $shutdown->id;
    self::waitForActionCompletion($client, $droplet_id, $shutdownActionId);

    $resizeResponse = self::downgradeTo1gb();
    $resizeActionId = $resizeResponse['action']['id'];
    self::waitForActionCompletion($client, $droplet_id, $resizeActionId);

    $powerOn = $droplet->powerOn($droplet_id);
    $powerOnActionId = $powerOn->id;
    self::waitForActionCompletion($client, $droplet_id, $powerOnActionId);
}

private static function waitForActionCompletion($client, $dropletId, $actionId)
{
    $droplet = $client->droplet();
    $maxRetries = 60;
    $retryInterval = 5; // in seconds

    for ($i = 0; $i < $maxRetries; $i++) {
        $action = $droplet->getActionById($dropletId, $actionId);
        if ($action->status === 'completed') {
            break;
        }

        sleep($retryInterval);
    }
}

private static function downgradeTo1gb($droplet_id = '310466241')
{
    $response = Http::withToken(env('DO_TOKEN'))
        ->post("https://api.digitalocean.com/v2/droplets/{$droplet_id}/actions", [
            "type" => "resize",
            "disk" => false,
            "size" => "s-1vcpu-1gb"
        ]);

    return $response;
}

}
