<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MagicLink;
use Illuminate\Support\Facades\URL;
use App\Models\Vlesson;
use Illuminate\Support\Facades\Cache;
use App\Models\Touchpoint;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use App\Models\ScheduledEmail;
use Illuminate\Support\Facades\Http;
use Propaganistas\LaravelPhone\PhoneNumber;
use Laravel\Nova\Nova;
use Illuminate\Support\Facades\Response;
use Google_Client;
use Google_Service_Calendar;
use Illuminate\Support\Str;
use App\Hydraulics\Contracting;
use Laravel\Nova\Actions\DispatchAction;
use Laravel\Nova\Http\Requests\ActionRequest;
use Illuminate\Support\Collection;
use App\Models\Contact;
use App\Models\SendportalSubscriber;
use App\Models\Sequencer;
use App\Models\Course;
use App\Models\Opps;
use Firebase\JWT\JWT;

use App\Models\CampaignContact;
use Illuminate\Support\Facades\Env;
use App\Hydraulics\Syncer;
use App\Models\VideoAudit;
use App\Models\Campaign;
use App\Hydraulics\AirBooker;
use App\Mail\MyMailGun;
use App\Notifications\LionNotification;
use App\Notifications\NowYouKnow;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use App\Jobs\SampleJobOne;
use App\Jobs\CampaignCreationJob;
use Illuminate\Support\Facades\Event;
use App\Nova\Actions\TestAction;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Request as PSRequest;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\OppEmail;
use Illuminate\Support\Facades\Storage;
use stdClass;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Google_Service_Calendar_EventAttendee;
use Laravel\Socialite\Facades\Socialite;



class PlayAround extends Controller
{

  public function neverOnSafety() {
    $contact = Contact::find(3599);
    return count($contact->user->campaigns);

  }
  
  public function updateAustralianContacts() {
    // Define the Australian country code
    $australianCountryCode = '61';

    // Get all contacts
    $contacts = Contact::all();

    foreach ($contacts as $contact) {
        $mobile = $contact->mobile;

        // Remove any non-digit characters, including spaces, from the mobile number
        $cleanedMobile = preg_replace('/\D/', '', $mobile);

        // Check if the number starts with the Australian country code, with or without the '+'
        if (substr($cleanedMobile, 0, 2) === $australianCountryCode) {
            $updatedMobile = substr($cleanedMobile, 2);
            $contact->country_code = $australianCountryCode;
        } elseif (substr($cleanedMobile, 0, 2) === '04') { // Australian mobile numbers starting with '04'
            $updatedMobile = substr($cleanedMobile, 2);
            $contact->country_code = $australianCountryCode;
        } elseif (substr($cleanedMobile, 0, 1) === '4') { // Australian mobile numbers starting with '4'
            $updatedMobile = substr($cleanedMobile, 1);
            $contact->country_code = $australianCountryCode;
        } elseif (substr($cleanedMobile, 0, 1) === '0') { // Australian mobile numbers starting with '0'
            $updatedMobile = substr($cleanedMobile, 1);
            $contact->country_code = $australianCountryCode;
        } else {
            // If the number doesn't match any of the patterns, ignore it
            continue;
        }

        // Update the 'mobile' column without the country code
        $contact->mobile = $updatedMobile;

        // Save the changes to the contact
        $contact->save();
    }
  }
  
  public function getTimezoneByCityName()
  {
      $cityName = "London, UK";
      $apiKey = env('GOOGLE_API_KEY'); // Replace with your actual Google Maps API key
  
      // Get the coordinates (latitude and longitude) of the city using the Google Maps Geocoding API
      $geocodeUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($cityName) . "&key=" . $apiKey;
      $geocodeResponse = Http::get($geocodeUrl);
      $geocodeData = $geocodeResponse->json();
  
      if (isset($geocodeData['results'][0]['geometry']['location'])) {
          $latitude = $geocodeData['results'][0]['geometry']['location']['lat'];
          $longitude = $geocodeData['results'][0]['geometry']['location']['lng'];
  
          // Get the timezone string using the Google Maps Timezone API
          $timestamp = time();
          $timezoneUrl = "https://maps.googleapis.com/maps/api/timezone/json?location=$latitude,$longitude&timestamp=$timestamp&key=" . $apiKey;
          $timezoneResponse = Http::get($timezoneUrl);
          $timezoneData = $timezoneResponse->json();
  
          if (isset($timezoneData['timeZoneId'])) {
              return $timezoneData['timeZoneId'];
          } else {
              return "Error: Timezone not found";
          }
      } else {
          return "Error: City not found";
      }
  }

  public function ueces() {
    $contacts = Contact::whereHas('touchpoints', function ($query) {
      $query->where('journey', 'LIKE', '%UEC%')
          ->where('call_result', '<>', 'Not Interested')
          ->where('date', '<', Carbon::now());
  })->get();
  return $contacts;

}

  public function timeZoner() {

    /*$city_timezones = [
      'Atherton' => 'Australia/Brisbane',
      'Kalgoorlie' => 'Australia/Perth',
      'Melbourne' => 'Australia/Melbourne',
      'Mysterton' => 'Australia/Brisbane',
      'Sydney' => 'Australia/Sydney',
      'Adelaide' => 'Australia/Adelaide',
      'Aitkenvale' => 'Australia/Brisbane',
      'Albion' => 'Australia/Brisbane',
      'Ardross' => 'Australia/Perth',
      'Aspley' => 'Australia/Brisbane',
      'Bargara' => 'Australia/Brisbane',
      'Bassendean' => 'Australia/Perth',
      'Battery Point' => 'Australia/Hobart',
      'Beeliar' => 'Australia/Perth',
      'Bellingen' => 'Australia/Sydney',
      'Bendigo' => 'Australia/Melbourne',
      'Berserker' => 'Australia/Brisbane',
      'Bethania' => 'Australia/Brisbane',
      'Blair Athol' => 'Australia/Adelaide',
      'Bower' => 'Australia/Adelaide',
      'Brisane City' => 'Australia/Brisbane',
      'Brisbane' => 'Australia/Brisbane',
      'Brisbane City' => 'Australia/Brisbane',
      'Brisbane, Brisbane' => 'Australia/Brisbane',
      'Broome' => 'Australia/Perth',
      'Brunswick West' => 'Australia/Melbourne',
      'Bulimba' => 'Australia/Brisbane',
      'Bundaberg South' => 'Australia/Brisbane',
      'Bundall' => 'Australia/Brisbane',
  ];*/

  /*$city_timezones = [
    'Bungalow' => 'Australia/Brisbane',
    'Burleigh Heads' => 'Australia/Brisbane',
    'Bushland Beach' => 'Australia/Brisbane',
    'Cairns City' => 'Australia/Brisbane',
    'Cannington' => 'Australia/Perth',
    'Capalaba' => 'Australia/Brisbane',
    'Capricorn Coast' => 'Australia/Brisbane',
    'Ceduna' => 'Australia/Adelaide',
    'Central Coast' => 'Australia/Sydney',
    'Charters Towers City' => 'Australia/Brisbane',
    'Chatswood' => 'Australia/Sydney',
    'Chermside' => 'Australia/Brisbane',
    'Chermside West' => 'Australia/Brisbane',
    'Chevron Island' => 'Australia/Brisbane',
    'Claremont' => 'Australia/Perth',
    'Cloverdale' => 'Australia/Perth',
    'Coffs Harbor' => 'Australia/Sydney',
    'Como' => 'Australia/Perth',
    'Cooktown' => 'Australia/Brisbane',
    'Coolah' => 'Australia/Sydney',
    'Coonabarabran' => 'Australia/Sydney',
    'Coorparoo' => 'Australia/Brisbane',
    'Cottesloe' => 'Australia/Perth',
    'Craigieburn' => 'Australia/Melbourne',
    'Dandenong North' => 'Australia/Melbourne',
    'Darlington' => 'Australia/Perth',
    'Darwin' => 'Australia/Darwin',
    'Darwin City' => 'Australia/Darwin',
    'Deloraine' => 'Australia/Hobart',
    'Devonport' => 'Australia/Hobart',
    'Duncraig' => 'Australia/Perth',
    'East Coast AUS' => 'Australia/Sydney',
    'East Launceston' => 'Australia/Hobart',
    'East Perth' => 'Australia/Perth',
    'East Victoria Park' => 'Australia/Perth',
    'Echuca' => 'Australia/Melbourne',
    'Emerald' => 'Australia/Brisbane',
    'Evandale' => 'Australia/Hobart',
    'Fairfield' => 'Australia/Sydney',
    'Fortitude Valley' => 'Australia/Brisbane',
    'Fremantle' => 'Australia/Perth',
    'George Town' => 'Australia/Hobart',
]; 
*/

/*$city_timezones = [
  'Gladstone Central' => 'Australia/Brisbane',
  'Glenorchy' => 'Australia/Hobart',
  'Gold Coast' => 'Australia/Brisbane',
  'Gosnells' => 'Australia/Perth',
  'Gracemere' => 'Australia/Brisbane',
  'Gungahlin' => 'Australia/Sydney',
  'Gunnedah' => 'Australia/Sydney',
  'High Wycombe' => 'Australia/Perth',
  'Hobart' => 'Australia/Hobart',
  'Hope Island' => 'Australia/Brisbane',
  'Huonville' => 'Australia/Hobart',
  'Innisfail' => 'Australia/Brisbane',
  'Invermay' => 'Australia/Hobart',
  'Irymple' => 'Australia/Melbourne',
  'Karratha' => 'Australia/Perth',
  'Kingston' => 'Australia/Hobart',
  'Kingston Beach' => 'Australia/Hobart',
  'Lakemba' => 'Australia/Sydney',
  'Lancelin' => 'Australia/Perth',
  'Launceston' => 'Australia/Hobart',
  'Leederville' => 'Australia/Perth',
  'Legana' => 'Australia/Hobart',
  'Lenah Valley' => 'Australia/Hobart',
  'Longford' => 'Australia/Hobart',
  'Mackay' => 'Australia/Brisbane',
  'Malaga' => 'Australia/Perth',
  'Mandurah' => 'Australia/Perth',
  'Medowie' => 'Australia/Sydney',
  'Melbourne' => 'Australia/Melbourne',
  'Mildura' => 'Australia/Melbourne',
  'Moonah' => 'Australia/Hobart',
  'Moorooka' => 'Australia/Brisbane',
  'Mosman Park' => 'Australia/Perth',
  'Mount' => 'Australia/Adelaide',
  'Mount Isa' => 'Australia/Brisbane',
  'Narrabri' => 'Australia/Sydney',
  'New Norfolk' => 'Australia/Hobart',
  'New Town' => 'Australia/Hobart',
  'Newcastle' => 'Australia/Sydney',
  'Newcastle ' => 'Australia/Sydney',
  'Noble Park' => 'Australia/Melbourne',
  'Noosa Heads' => 'Australia/Brisbane',
  'Norman Park' => 'Australia/Brisbane',
  'North Adelaide' => 'Australia/Adelaide',
  'North Hobart' => 'Australia/Hobart',
  'North Perth' => 'Australia/Perth',
  'North Ward' => 'Australia/Brisbane',
]; */

// Define the mapping of cities to time zones
$city_timezones = [
  'Osborne Park' => 'Australia/Perth',
  'Otago' => 'Australia/Hobart',
  'Oxenford' => 'Australia/Brisbane',
  'Padbury' => 'Australia/Perth',
  'Palmyra' => 'Australia/Perth',
  'Perth' => 'Australia/Perth',
  'Pipers River' => 'Australia/Hobart',
  'Plympton' => 'Australia/Adelaide',
  'Port Macquarie' => 'Australia/Sydney',
  'Prospect' => 'Australia/Adelaide',
  'Red Hill' => 'Australia/Brisbane',
  'Redbank' => 'Australia/Brisbane',
  'Redlynch' => 'Australia/Brisbane',
  'Rochedale' => 'Australia/Brisbane',
  'Rockhampton' => 'Australia/Brisbane',
  'Rosny Park' => 'Australia/Hobart',
  'Sandy Bay' => 'Australia/Hobart',
  'Shepparton' => 'Australia/Melbourne',
  'Shops' => 'Australia/Adelaide',
  'Sorell' => 'Australia/Hobart',
  'South' => 'Australia/Melbourne',
  'South Brisbane' => 'Australia/Brisbane',
  'South Launceston' => 'Australia/Hobart',
  'South Perth' => 'Australia/Perth',
  'Southside' => 'Australia/Brisbane',
  'Spring Hill' => 'Australia/Brisbane',
  'Springfield Lakes' => 'Australia/Brisbane',
  'St Helens' => 'Australia/Hobart',
  'St Kilda' => 'Australia/Melbourne',
  'Streaky Bay' => 'Australia/Adelaide',
  'Subiaco' => 'Australia/Perth',
  'Sunshine coast' => 'Australia/Brisbane',
  'Surfers Paradise' => 'Australia/Brisbane',
  'Swan Hill' => 'Australia/Melbourne',
  'Sydney' => 'Australia/Sydney',
  'Tamworth' => 'Australia/Sydney',
  'Teneriffe' => 'Australia/Brisbane',
  'Texas, US' => 'America/Chicago',
  'Toodyay' => 'Australia/Perth',
  'Townsville' => 'Australia/Brisbane',
  'Townsville City' => 'Australia/Brisbane',
  'Two Rocks' => 'Australia/Perth',
  'Victoria' => 'Australia/Melbourne',
  'Walkerville' => 'Australia/Adelaide',
  'Wanguri' => 'Australia/Darwin',
  'Wanneroo' => 'Australia/Perth',
  'West End' => 'Australia/Brisbane',
  'Westbury' => 'Australia/Hobart',
  'Whitsundays' => 'Australia/Brisbane',
  'Winnellie' => 'Australia/Darwin',
  'Wodonga' => 'Australia/Melbourne',
  'Woolloomooloo' => 'Australia/Sydney',
  'Wynnum' => 'Australia/Brisbane',
  'Yeppoon' => 'Australia/Brisbane',
];
  
  // Get the contacts from the database
  $contacts = DB::table('contacts')->whereIn('city', array_keys($city_timezones))->get();
  
  // Update the timezone column for each contact
  foreach ($contacts as $contact) {
      $city = $contact->city;
      if (isset($city_timezones[$city])) {
        $timezone = $city_timezones[$city];
        $contact_time = Carbon::now($timezone);
        DB::table('contacts')->where('id', $contact->id)->update(['timezone' => $timezone]);
      }
      $contact_time = Carbon::now($timezone);
      DB::table('contacts')->where('id', $contact->id)->update(['timezone' => $timezone]);
  }
    
  }

  public function giveMeNames() {

    $contact = Contact::find(4066);

    return $contact->displayStakeholderNames();

  }

  public function redirectToGoogle()
{
    return Socialite::driver('google')
        ->scopes(['openid', 'profile', 'email', 'https://www.googleapis.com/auth/calendar.events'])
        ->redirect();
}

public function handleGoogleCallback()
{
    // Get the user's access token
    $user = Socialite::driver('google')->user();
    $accessToken = $user->token;

    session(['google_access_token' => $accessToken]);

    return redirect('/nova/dashboards/main');

    
}

  

  function initializeGoogleCalendarClient($credentialsPath)
{
    $client = new Google_Client();
    $client->setApplicationName('Google Calendar API Laravel');
    $client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
    $client->setAuthConfig($credentialsPath);
    $client->setAccessType('offline');

    return new Google_Service_Calendar($client);
}

  public function scheduleMeeting()
    {
        $apiKey = 'your_api_key';
        $apiSecret = 'your_api_secret';
        $jwtToken = $this->generateZoomJWTToken(env('ZOOM_API'), env('ZOOM_SECRET'));

        $url = 'https://api.zoom.us/v2/users/me/meetings';
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $jwtToken,
        ];
        $body = [
            'topic' => 'Test Meeting',
            'type' => 2,
            'start_time' => '2023-04-01T10:00:00Z', // Set a future date and time in the UTC timezone
            'duration' => 30,
            'timezone' => 'UTC',
            'settings' => [
                'join_before_host' => true,
                'waiting_room' => false,
            ],
        ];

        $response = Http::withHeaders($headers)->post($url, $body);

        if ($response->successful()) {
            $meetingDetails = $response->json();
            $joinUrl = $meetingDetails['join_url'];
            return $joinUrl;

            // You can now use the $joinUrl as needed
            // For example, return it as a response or save it in your database
        } else {
            // Handle errors and exceptions
        }
    }

  public function zoomzoom() {
    return $this->generateZoomJWTToken(env('ZOOM_API'), env('ZOOM_SECRET'));
  }

  public function generateZoomJWTToken($apiKey, $apiSecret)
  {
      $payload = [
          'iss' => $apiKey,
          'exp' => time() + 3600, // Expires in 1 hour
      ];
  
      return JWT::encode($payload, $apiSecret, 'HS256');
  }

  public function unsubscriber() {
    $unsubscribeEmails = file('unsubscribes.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $this->syncAirtableUnsubscribes($unsubscribeEmails);
    return "We have lift off";
  }

  function syncAirtableUnsubscribes(array $unsubscribeEmails)
{
    // Normalize the email addresses to lowercase for case-insensitive search
    $unsubscribeEmails = array_map(function ($email) {
        return Str::lower($email);
    }, $unsubscribeEmails);

    // Find the subscribers with email addresses in the unsubscribeEmails list
    $subscribers = SendportalSubscriber::whereIn(
        DB::raw('LOWER(email)'),
        $unsubscribeEmails
    )->get();

    // Update the 'unsubscribed_at' and 'unsubscribe_event_id' columns
    $currentTimestamp = Carbon::now();
    $unsubscribeEventId = 4;

    foreach ($subscribers as $subscriber) {
        $subscriber->unsubscribed_at = $currentTimestamp;
        $subscriber->unsubscribe_event_id = $unsubscribeEventId;
        $subscriber->save();
    }
}

  public function showWithPlayButton()
    {
      $campaignId = 273;
        $campaign = Campaign::findOrFail($campaignId);
        $thumbnailWithPlayButton = $campaign->generateThumbnailWithPlayButton();

        return $thumbnailWithPlayButton;

        // Return the modified thumbnail as a response
        return Response::make($thumbnailWithPlayButton, 200, [
            'Content-Type' => 'image/png',
        ]);
    }

  public function signed_delivered() {

    // http://127.0.0.1/nova/resources/contacts/4058

    $user = User::find(1); // Replace with the actual user you want to send the email to
    $magicLink = MagicLink::generate($user);

    $resourceUrl = '/nova/resources/contacts/4058'; // Replace this with the desired dynamic Nova resource URL
    $magicUrl = URL::temporarySignedRoute('magic-login', now()->addHour(), [
    'magic_token' => $magicLink->token,
    'resource_url' => $resourceUrl,
    ]);

    return $magicUrl;

  }

  public function nowyouknow() {
    
    $user = User::find(1);
    Notification::send($user, new NowYouKnow('Client Clicked', 'A Landing Page Has Been Viewed', 'The landing page for x has been viewed', 'View Touchpoint', 'https://rrdevours.monster/nova/resources/campaigns/360'));
      return "And now we wait";
  }

  public function updateEunsubscribedStatus()
{
    $fileName = 'eunsubs.txt'; // Replace with your file name
    $filePath = public_path($fileName);

    // Read the file and create the emails array
    $emails = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Update 'unsubscribed_at' column to now() for the given email addresses
    $updatedCount = SendportalSubscriber::whereIn('email', $emails)->update(['unsubscribed_at' => Carbon::now()]);

    // Return the number of updated records
    return response()->json([
        'message' => 'Unsubscribed status updated',
        'updatedCount' => $updatedCount,
    ]);
}

  public function gory() {

    dump("Gory guts");

    $contact = Contact::find(3959);

    $audit = $contact->audit->v_thumbnail;
    return $audit;

  }

  public function fielder() {

   $email = ScheduledEmail::find(81);
   return $email->fields['subject'];

    //$syncMan = app()->make('SyncMan')->dumpa();

  }

  public function screenshot() {

    return app()->make('CampMan')->createThumb('https://rent-roll-devour-bucket-a1.s3.ap-southeast-2.amazonaws.com/videos/scripts/final/script_575.mp4');

    $url = 'https://rent-roll-devour-bucket-a1.s3.ap-southeast-2.amazonaws.com/videos/scripts/final/script_922.mp4';

// Parse the URL to get the path component
$path = parse_url($url, PHP_URL_PATH);
$path = ltrim($path, '/');

return $path; // outputs "videos/scripts/final/script_922.mp4"

    FFMpeg::fromDisk('s3')
    ->open('videos/scripts/final/script_238.mp4')
    ->getFrameFromSeconds(3)
    ->export()
    ->toDisk('s3')
    ->save('images/screenshots/braaac.png');

    $imgurl = Storage::url('images/screenshots/braaac.png');

    $image = \WideImage\WideImage::load($imgurl);
                
    $resized = $image->resize(850, 450, 'outside');
    $data = $resized->asString('png');
    $result = Storage::disk('s3')->put('images/screenshots/braaac.png', $data);
    return Storage::url('images/screenshots/braaac.png');
  }

  public function helpme() {

    dump("Give me a chance");

    return "Dance!";

    $contacts = DB::connection('mysql_staging')->table('contacts')->get();
    return $contacts;

  }

  public function hear() {  

    

    $campaign = Campaign::find(333);

    $video = $campaign->tiktok_url;
    $path = 'videos/scripts/final/script_'.rand(0,1000).'.mp4';

    Storage::put($path, fopen($video, 'r'));
    $url = Storage::disk('s3')->url($path);                    

    $campaign->tiktok_url = $url;
    $campaign->save();

    return "Tip of my tennis shoe";

    dump("You hear the calls?");

    //$user = User::find(87);
    //ScreenshotModel::dispatch($user)->onQueue('mail');

  }

  public function proppas() {

    SampleJobOne::dispatch()->delay(now()->addMinutes(5));

    SampleJobOne::dispatch();

    return "Sample job with new stuff?";

    dump("We getting hot in here!");

    Cache::store('redis')->put('key', 'booyakasha', 60);


    $value = Cache::store('redis')->get('key');

    if ($value === null) {
        return('Data not found in Redis cache.');
    }

    return "Data retrieved from Redis cache: {$value}";



    $original = Opps::findOrFail(44);
    
    // Create a new Opp model with the same attributes as the original
    $newOpp = $original->replicate();

    $newOpp->save();

    return "Reppa";

    $oppa = Opps::find(47);
    $proppas = $oppa->getStakeholdersCollection();
    foreach($proppas as $proppa) {
      //return $proppa->attributes->name;
      $mobile = '0415 932 797';
      $email = 'j.smith@gmail.com';
      $proppa->attributes->contact_details = 'Mobile: '.$mobile."\n".'Email: '.$email;
    }

    $oppa->setStakeholdersCollection($proppas);
    $oppa->save();
    return $oppa;

    return $proppas;

    return $proppas;

    foreach($proppas as $key => $proppa) {
      
      $timestamp = strtotime('+10 days');
      $dateString = date('Y-m-d', $timestamp);
      
      $proppas[$key]->attributes->completion = $dateString;
      
      
    }

    

    //$proppas = collect($proppa);

    $oppa->setScheduleCollection($proppas);
    //return $oppa;
    $oppa->save();
    
    return $oppa;
    return "Proppa Whiskey!";
  }

  public function dispatcha() {

    //SampleJobOne::dispatch()->onConnection('database')->delay(now()->addMinutes(1));

    //SampleJobOne::dispatch()->onConnection('database')->delay(now()->addMinutes(1));
    SampleJobOne::dispatchNow();

    
    return "Dispatcha";

  }

  public function tabler() {

    dump("WUT?");

    $table1Rows = DB::table('touchpoints')->get();

    foreach ($table1Rows as $row) {
      //$journey = explode(',', $row->journey);
      
      if (strpos($row->journey, 'UEC') !== false) {
        DB::table('touchpoints')
            ->where('id', $row->id)
            ->update(['uec' => 1]);
        dump("We hear you!");
            dump($row);
          /*DB::table('uec')->insert([
            
              //'id' => $row->id,
              //'value' => 1
          ]); */
      }
  }

    


  }

  public function terminallyill() {

    //$command = 'ffmpeg --help'; // command you want to execute
    $dir = '/home/forge/dev1.rrdevours.monster'; // command you want to execute
    chdir($dir);
    //$output = shell_exec($command); 
    $command = 'ls'; // command you want to execute
    $output = shell_exec($command); 

    return view('test.ffmpeger', compact('output'));

  }

  public function vmclear() {

    $fields = new stdClass();
      $fields->template = 'emails.sequence';
      return $fields;
    //return app()->make('CampMan')->vmclear();

    $contact = Contact::find(875);
    //return $contact->user->screenshot;
    return $contact->user->full_url;

    return "Hello?";
  }

  public function myschedule() {


    $sequence = Sequencer::find(1);
    $sequencers = $sequence->getPropsCollection();

    $mdelay = 0;
    foreach($sequencers as $item) {

      if($item->layout == 'email_single') {
        dump("I haear an email!");
        $model = Contact::find(3959);
        $fields = new stdClass();
        $delay = $item->attributes->delay_hours;
        
        $mdelay = $mdelay + $delay; // Add 1 minute to the delay for each email
        dump("Delay hours is: ".$delay);
        dump("Total delay is: ".$mdelay);
        $message = $item->attributes->email_body;
        
        
        $fields->template = 'emails.simple';

        $scheduledEmail = new ScheduledEmail();
        $scheduledEmail->contact_id = $model->id;
        $scheduledEmail->message = $message;
        $scheduledEmail->template = 'emails.simple';
        $scheduledEmail->scheduled_at = now()->addMinutes($mdelay); // Schedule the email to be sent in 10 minutes.
        $scheduledEmail->save();
              

      }
    }

    return "Check the dumpa";


    

  }

  public function loopa_new() {

    $sequence = Sequencer::find(1);
    $sequencers = $sequence->getPropsCollection();

    $mdelay = 0;
    foreach($sequencers as $item) {

      if($item->layout == 'email_single') {
        dump("I haear an email!");
        $fields = new stdClass();
        $mdelay = $mdelay + 1; // Add 1 minute to the delay for each email
        $fields->message = $item->attributes->email_body;
        $fields->template = 'emails.simple';
        dump("Delay should be going up by... ".$mdelay);
        $mail = new MyMailGun($model, $fields);
        //$timestamp = date('l jS \of F Y h:i:s A');
        //$delayMessage = "This is scheduled at {$timestamp} and delayed by {$mdelay} minutes. ";
        
      }
      //dump("Item layout is: ".$item->layout);
      //if($item->layout == 'email_single') {
        //dump("How many?");
        /*$message = $item->attributes->email_body;
        $model = Contact::find(3959);
        $fields = new stdClass();
        $mdelay = $mdelay + 1; // Add 1 minute to the delay for each email
        dump("Delay should be going up by... ".$mdelay);
        $fields->template = 'emails.simple';
        $timestamp = date('l jS \of F Y h:i:s A');
        $delayMessage = "This is scheduled at {$timestamp} and delayed by {$mdelay} minutes. ";
        $fields->message = $delayMessage.$message;
        $msg_name = substr($model->name.' - '.$item->attributes->subject, 0, 80);
        dump("We getting the following subject now: ");
        dump($msg_name); */
        /*\Binarcode\LaravelMailator\Scheduler::init($msg_name)
        ->mailable(new MyMailGun($model, $fields))
        ->recipients('enquiries@headstudios.com.au')
        ->minutes($mdelay)
        ->after(\Carbon\Carbon::now())
        ->save();*/
        
      }
    }

  public function looper() {

    $sequence = Sequencer::find(1);
    $sequencers = $sequence->getPropsCollection();

    //return $sequencers;

    $mdelay = 0;
    foreach($sequencers as $item) {
      if($item->layout == 'email_single') {
        $message = $item->attributes->email_body;
        $model = Contact::find(3959);
        $fields = new stdClass();
        $mdelay = $mdelay + $item->attributes->delay_hours;
        dump("Delay should be going up by... ".$mdelay);
        $fields->template = 'emails.simple';
        $timestamp = date('l jS \of F Y h:i:s A');
        $delayMessage = "This is scheduled at {$timestamp} and delayed by {$mdelay} minutes. ";
        $fields->message = $message;




        /*
        \Binarcode\LaravelMailator\Scheduler::init($msg_name)
        ->mailable(new MyMailGun($model, $fields))
        ->recipients('enquiries@headstudios.com.au')
        ->minutes(1)
        ->after(\Carbon\Carbon::now())
        ->save();*/
        
      }
      
      //return $item->attributes->subject;
      //return $item->attributes->email_body;
      //return $item->attributes->delay_days;
      

    }
    return "Completed!";
    $loop = $sequence->sequence;

    foreach($loop as $item) {
      dump("Go single!");
      dump($item);
    }


  }


  public function mschedule() {

    $data = [
      'name' => 'John',
      'message' => 'Hello, this is a test email.'
  ];

  // Create a stdClass object with some random variables for fields
$fields = new stdClass();
$fields->template = 'emails.simpleaaaaaa';
$fields->message = 'Hello, world!';


// Assuming the $model variable is an instance of the Contact model
$model = Touchpoint::find(4211);

// Pass $model and $fields into the MyMailGun instanc

    \Binarcode\LaravelMailator\Scheduler::init('One Minute Wait')
    ->mailable(new MyMailGun($model, $fields))
    ->recipients('enquiries@headstudios.com.au')
    ->minutes(1)
    ->after(now())
    ->save();

    return "Noooo!";

    $sendAt = Carbon::now();
    $dateTime = now();

    $message = new MyMailGun($data, 'emails.simple');
    Mail::to('enquiries@headstudios.com.au')->send($message);

  }

  public function databaser() {
    $contact = Contact::find(869);
    return $contact;
    return DB::connection()->getDatabaseName();
    return DB::getDatabaseName();
    $touchpoints = DB::select("
    SELECT
    air_contact_id,
    SUM(consecutive_voicemails) AS total_consecutive_voicemails
FROM (
    SELECT
        air_contact_id,
        COUNT(*) AS consecutive_voicemails
    FROM (
        SELECT
            *,
            DATE(date) - INTERVAL @rank:=IF(@prev_contact = air_contact_id AND call_result = 'Voicemail', @rank + 1, 1) DAY AS voicemail_group,
            @prev_contact:=air_contact_id
        FROM touchpoints
        CROSS JOIN (SELECT @rank:=0, @prev_contact:=0) AS vars
        WHERE LOWER(TRIM(call_result)) NOT IN (LOWER(TRIM('Not Interested')), LOWER(TRIM('Disqualified')))
          AND date <= NOW()
        ORDER BY air_contact_id, date
    ) AS t
    WHERE call_result = 'Voicemail'
    GROUP BY air_contact_id, voicemail_group
) AS u
GROUP BY air_contact_id
ORDER BY total_consecutive_voicemails ASC
LIMIT 10;
    ");
    return $touchpoints;
  }

  public function air_contacts() {

    $booker = new AirBooker;
    $rows = $booker->getRecordsFromView('ProspectList', 'Contact');
    foreach ($rows as $column) {
      foreach($column as $record) {

        if(isset($record->fields->City)) {

        $contact = Contact::where('air_id', $record->id)->first();
        if($contact) {
          $contact->city = $record->fields->City;
          $contact->save();
          dump("We just got ".$contact->name." with ".$contact->email." for City: ".$record->fields->City);
        } 

      }

  }
}
  }

  public function air() {
    $booker = new AirBooker;
    $rows = $booker->getRecordsFromView('All', 'Touchpoints');

    $count = 0;
    
    foreach ($rows as $column) {
        foreach($column as $record) {
           

            // Store the relevant fields from the record
            $notes = isset($record->fields->Notes) ? substr($record->fields->Notes, 0, 250) : '';
            $airId = $record->id;
            dump("Record is: ");
            dump($record);
            $airContactId = isset($record->fields->Contact[0]) ? $record->fields->Contact[0] : '';
            $journeyString = isset($record->fields->Journey) ? json_encode($record->fields->Journey) : '';
            $callResult = isset($record->fields->{'Call Result'}) ? $record->fields->{'Call Result'} : '';


           
            dump("The journey string is: ");
            dump($journeyString);

            // Convert the date string to a Carbon instance
            
            $startDateTime = null;
            if (isset($record->fields->{'Start DateTime'})) {
                try {
                    $startDateTime = Carbon::parse($record->fields->{'Start DateTime'});
                } catch (Exception $e) {
                  $startDateTime = '';
                }
            }

            // Create a new Touchpoint model
            $touchpoint = new Touchpoint();

            // Set the properties of the model
            $touchpoint->date = $startDateTime->format('Y-m-d');
            $touchpoint->notes = $notes;
            $touchpoint->air_contact_id = $airContactId;
            $touchpoint->journey = $journeyString;
            $touchpoint->call_result = $callResult;
            $touchpoint->air_id = $airId;

            // Save the model to the database
            $touchpoint->save();

            $count++;
        }
    }
    
  }

  public function form(Request $request) {
    
    
    return "Check it!";
  }

  public function gimmecontacts() {
    $contacts = Contact::where(function ($query) {
      $query->where('unsubscribed', 0)
      ->orWhereNull('unsubscribed');
      })
      ->inRandomOrder()
      ->limit(15)
      ->get();
      return $contacts;
  }

  

  public function former() {
    return view('test.former');
  }

  public function youtuber() {
    $client = new \Google\Client();
    $client->setApplicationName("YouTuber");
    $client->setDeveloperKey(env('YOUTUBE_API_KEY'));
    $client->setScopes('https://www.googleapis.com/auth/youtube'); 
    $youtube = new \Google\Google_Service_YouTube($client);
    return "Bring the pain!";
  }

  public function camper() {
    $user = User::find(100);
    //return $user->full_url;
    $audit = VideoAudit::find(61);
    $campaign = Campaign::find(302);
    app()->make('CampMan')->screenshotModel($user);
  }

  public function createCampContact() {

    Contact::where(function ($query) {
      $query->where('unsubscribed', 0)
      ->orWhereNull('unsubscribed');
  })
  ->inRandomOrder()
  ->limit(40)
  ->chunk(8, function ($contacts) {
      
      //LocalJob::dispatch($model->id, $contacts, $fields);
  });


    return "Working!";

    //Nothing::dispatch();

    CampaignCreationJob::dispatch();
    /*
    $contacts = Contact::where(function ($query) {
      $query->where('unsubscribed', 0)
      ->orWhereNull('unsubscribed');
      })
      ->inRandomOrder()
      ->limit(2)
      ->get();
    
      $fields = array('left' => 10, 'top' => 10, 'size' => 24);

      $campaign_id = 306;

      foreach($contacts as $contact) {

      $camp = CampaignContact::firstOrCreate([
        'campaign_id' => $campaign_id,
        'contacts_id' => $contact->id,
        'action_fields' => $fields
        ]);

      } */
      return "WORKING!!! DISPATCHING!!!!";
      
      
  }

  public function shallpass() {
    //return "Ye shall not pass!";
    $user = User::find(1);
    if($user->hasRole('admin')) {
      return "You are a GOD!";
    }
  }

  public function mailit() {
    $data = [
      'name' => 'John',
      'message' => 'Hello, this is a test email.'
  ];

  $sendAt = Carbon::now();
  $dateTime = now();

  $message = new MyMailGun($data, 'emails.simple');
  Mail::to('enquiries@headstudios.com.au')->send($message); //->later(now(), new MyMailGun($data, 'emails.simple'));


  /*$message = (new MyMailGun($data, 'emails.simple'))
                ->onConnection('redis')
                ->onQueue('mail');


  Mail::to('enquiries@headstudios.com.au')->later(Carbon::now(), $message); */


  //Mail::to('enquiries@headstudios.com.au')->later(now(), new MyMailGun($data, 'emails.simple'));

  return "Mailtime!";
  }

  

  public function ffmpeger() {
    $campaign = Campaign::find(341);
    $ffmpeg = $campaign->ffmpeg;
    return app()->make('CampMan')->ffmpeg($ffmpeg);
    //return view('test.ffmpeger', ['ffmpeg' => $ffmpeg]);
  }
  
  public function dumper() {
    $campaign = Campaign::find(329);
    app()->make('CampMan')->json_dumper($campaign);
    return "Check the dumps!";
  }

  public function linkup(Request $request) {
    $provider = new \League\OAuth2\Client\Provider\LinkedIn([
    'clientId' => env('LINKEDIN_CLIENTID'),
    'clientSecret' => env('LINKEDIN_SECRET'),
    'redirectUri' => 'https://dev1.rrdevours.monster/airbooker',
    ]);
    $options = [
      'scope' => ['w_member_social']
      ];
    if (!$request->query('code')) {

    
    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl();
    $request->session()->put('oauth2state', $provider->getState());
    header('Location: '.$authUrl);
    exit;
    // Check given state against previously stored one to mitigate CSRF attack
  } else {
    
    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
      'code' => $request->query('code')

    ]);

    // Optional: Now you have a token you can look up a users profile data
    try {
      // We got an access token, let's now get the user's details
      $user = $provider->getResourceOwner($token);
      $accessToken = $token->getToken();

      $response = Http::withToken($accessToken)->withHeaders([
        'X-Restli-Protocol-Version' => '2.0.0',
        'Content-Type' => 'application/json'
    ])->post('https://api.linkedin.com/v2/posts', [
        'author' => 'urn:li:person:YOUR_URN_ID',
        'lifecycleState' => 'PUBLISHED',
        'specificContent' => [
            'com.linkedin.ugc.ShareContent' => [
                'shareCommentary' => [
                    'text' => 'Sample post text goes here'
                ],
                'shareMediaCategory' => 'NONE'
            ]
        ],
        'visibility' => [
            'com.linkedin.ugc.MemberNetworkVisibility' => 'PUBLIC'
        ]
    ]);
      
      

      return 'Hello '.$user->getFirstName().'! A post has been published on your LinkedIn account.';
  } catch (Exception $e) {
      // Failed to get user details
      return 'Oh dear...';
  }

  return "You should never see this!";

    }
  }

  public function ssh_forever() {
    $records = DB::connection('remote_mysql')
    ->table('Message')->where('status', 'Received')
    ->where(function($query) {
        $query->where('message', 'regexp', '(?i)\bStop\b')
        ->orWhere('message', 'regexp', '(?i)\bUnsubscribe\b')
        ->orWhere('message', 'regexp', '(?i)\bRemove\b');
    })->get();

    return $records;
    return Str::bigone('Peter');
    $campaign = Campaign::find(306);
    $destination_url = $campaign->full_url;
    return $destination_url;
    $var = 0;
    Contact::where('unsubscribed', 0)
    ->orWhereNull('unsubscribed')
    ->limit(40)
    ->chunk(8, function (Collection $contacts) use(&$var) {
      if($var > 8) { return; }
        
        $var++;
        
    });
    return "Check the dumps!";
    /*$records = DB::connection('remote_mysql')
    ->table('Message')->where('status', 'Received')
    ->where(function($query) {
        $query->whereRaw("message REGEXP '[[:<:]]Stop[[:>:]]'")
        ->whereRaw("message REGEXP '[[:<:]]Remove[[:>:]]'")
        ->whereRaw("message REGEXP '[[:<:]]Unsubscribe[[:>:]]'");
    })->get();*/

    $records = DB::connection('remote_mysql')
    ->table('Message')->where('status', 'Received')
    ->where(function($query) {
        $query->where('message', 'regexp', '(?i)\bStop\b')
        ->orWhere('message', 'regexp', '(?i)\bUnsubscribe\b')
        ->orWhere('message', 'regexp', '(?i)\bRemove\b');
    })->get();

    return $records;
  }
  
  public function queuePlay() {
    //SampleJobOne::dispatch();
    
    return "Queue time!";
  }
  public function contactPlay() {
    return Contact::updateOrCreateContact(['email' => 'brian@gumble.com', 'name' => 'Brian Gumble', 'mobile' => '0453923831', 'website' => 'https://soinsecure.com', 'account' => 'Insecure Co']);
  }
  public function unsub() {
    $syncair = new Airbooker;
    $syncair->unsubscribeContactFromEmail('greg@metrocityrealty.com.au ');
    }
    public function playtime() {
        return "We want to play";
    }

    public function updater() {
      $contact = Contact::where('email', 'Paul@realtorgc.com')->first();
      
                    if ($contact) {
                        $contact->name = "BOOYAKASHA";
                        $contact->save();
                        
                        
                    }
    }

    public function jobzoomer() {
        for($i = 0; $i < 10; $i++) {
            
        }
        return "Jobs dispatched - watch and learn";
    }

    public function pdf_play() {
        $opp = Opps::find(42);
        $client_logo = Storage::disk('s3')->url($opp->client_logo);
        $paylink = self::generatePriceURL(1000, false);

        $pay_opt = self::generatePriceUrl(1000, true);
        $data = [
            'title' => 'Mail from The Meastro',
            'name' => 'Bublisey',
            'company' => $opp->company,
            'logo' => $client_logo,
            'body' => $opp->email_body,
            'challenge' => $opp->challenge,
            'summary' => $opp->exec_summ,
            'products' => $opp->products,
            'terms' => $opp->terms,
            'stakeholders' => $opp->stakeholders,
            'schedule' => $opp->schedule,
            'paylink' => $paylink,
            'payopt' => $pay_opt,
            'subject' => "Let's goooo"

        ];

        //Mail::to($opp->email)->cc('enquiries@headstudios.com.au')->send(new \App\Mail\OppsEmail($data));

        //$pdf = Pdf::loadView('pdf.agreement', compact('data'));
        return view('pdf.agreement-live', compact('data'));
        return $pdf->stream('agreement.pdf');
    }

    public function novacall() {
        $opp = Opps::find(42);
        //Event::dispatch(new TestAction());
        $result = self::postToActionsApi(TestAction::class, 'Opps', $opp, ['test' => 'test'], User::find(1));
        return $result;
    }


    protected function postToActionsApi($actionClass, $resource, $model, $params, $user) {

        
        
        Nova::resourcesIn(app_path('Nova'));

        $collection = Collection::wrap($model);
        $action = new $actionClass;

        $actionRequest = app(ActionRequest::class);
        $actionRequest->user = $user;
        $actionRequest->setUserResolver(function () use ($user) {
            return $user;
        });
        
        $actionRequest = $actionRequest->replace($params);
        $actionRequest->route()->setParameter('resource',  $resource);
        $actionRequest->route()->pathInfo = '/nova-api/'.$resource.'/action';
        $actionRequest->action = $actionRequest->query->set('action', $action->uriKey());
        $actionRequest->action = $actionRequest->query->set('pivotAction', 'false');
        //return "The whole thing basically works";
        //$fields = $actionRequest->resolveFields();

        

        return DispatchAction::forModels(
            $actionRequest, 
            $action, 
            'handle', 
            $collection, 
            $fields
        );
    }



public function productprice() {

    //$opp = Opps::find(42);
    $invoice_url = Contracting::generateInvoice(42);
    return $invoice_url;
    $products = $opp->products;
    foreach($products as $product) {
      return $product->price;
    }


}

    public function theoldgames() {
        $opp = Opps::find(42);
    foreach($opp->products as $product) {
      //$product = $product->toArray();
      //return $product;
      foreach($product->itemised_price as $item) {
        return $item->attributes->item_name."Bra";
      }
      
    }

    $records = DB::connection('remote_mysql')
    ->table('Message')->where('status', 'Received')
    ->where(function($query) {
        $query->where('message', 'LIKE', '%No%'); 
    })->get();

    return $records;

    $contact = CampaignContact::find(5396);

    SendAMessage::dispatch($contact);

    return "And now we wait.... why wont it work.";

    $parsedown = new \Parsedown();
        
    $url = 'https://accounts.zoho.com/oauth/v2/token?refresh_token='.env('zoho_refresh_token').'&client_id='.env('zoho_client_id').'&client_secret='.env('zoho_client_secret').'&redirect_uri=http://www.zoho.com/books&grant_type=refresh_token';

    $response = Http::post($url);

    $response = json_decode($response,true);

    $access_token = $response['access_token'];

    return $access_token;

    return "The ID is: ".

    //Notification::send('enquiries@headstudios.com.au', new OppNotification());
    Mail::to('enquiries@headstudios.com.au')->send(new OppEmail(['subject' => 'Test Subject', 'body' => 'Test Message', 'name' => 'Test Name']));
    return "GO!";

    $bookman = new AirBooker();
    $records = $bookman->getRecordsFromView("EUNSUB");
    return $records;
    return $records[3]->fields;

    $destination_url = 'https://mydestination.com/insight/big-offer';
    $short_key = 'big-offer';
    $contact = Contact::find(27);
    

    /*return view('pdf.agreement');

     */

    
    return "Wait for the dump";



    $mobile = PhoneNumber::make('+61463315544', 'AU')->formatE164();
    return $mobile;

    $syncer = new Syncer();
    $nums = $syncer->syncContactsFromAirTable();
    return "Check the syncer";

    $campaign = Campaign::find(306);
    return $campaign->short_url;

    
    return $shortURL;

    CampaignContact::updateOrCreate(
        ['campaign_id' => 306, 'contacts_id' => 3885],
        ['mms_msg' => 'Make an amazing come back update
        Not only are there new lines?
        
        But I can update with impunity.']
    );

    return "Let us check the attached";

    
    return "Wait for the dump";

    $campaign = Campaign::find(306);
    return $campaign->full_url;


    
    return "Total records is: ".$nums;

    $bookman = new AirBooker();
    $records = $bookman->getRecordsFromView("ELIST");
    foreach($records as $record) {
        return $record;
    }

    

    

    $campaignContact = new CampaignContact;
    $campaignContact->campaign_id = 5;
    $campaignContact->contacts_id = 69;
    $campaignContact->mms_msg = 'This time someone come and rescue me!';
    $campaignContact->save();

    return "Check it bro!";

    $builder = new \AshAllenDesign\ShortURL\Classes\Builder();

    $shortURLObject = $builder->destinationUrl('https://google.com')->urlKey('google-key')->make();
    $shortURL = $shortURLObject->default_short_url;
    return $shortURL;

    $user = User::find(93);
    $course = Course::find(3);

    $checklists = $user->getChecklistsIn($course);
    $lessons = $course->getLessonsBy($user);

    Notification::send($user, new LionNotification($user, $course, $lessons, $checklists));

    return "Will notifications ever work?";

    return "Go boi!";

    KingAttacher::dispatch(3878, 304);

    return "Hello route!";

    KingAttacher::dispatch(3878, 304);

   


    

    $sendportal = SendportalSubscriber::all();

    
    $contacts = Contact::all()->keyBy('mobile');
    $records = [];
    $request = $bookman->getRecords("EUNSUB");
    $x = 0;
    do {
        $response = $request->getResponse();
        //foreach($response['records'] as $record) {
            $records[] = $response[ 'records' ];
            //if($x < 1500) {
              //if (isset($record->fields->phone)) {
                //if (isset($contacts[PhoneNumber::make($record->fields->phone, 'AU')->formatE164()]) && $contacts[PhoneNumber::make($record->fields->phone, 'AU')->formatE164()]->unsubscribed == 0) {
                    
                    //
                    //
                    //
                    //return $contacts[$record->fields->Email];
                    //
                    //return $contacts[PhoneNumber::make($record->fields->phone, 'AU')->formatE164()];
                    //$contacts[$record->fields->Email]->unsubscribe = 1;
                  //}
                //$x++;
              //}
            //}
          }
    while( $request = $response->next() );
    }

    protected function generatePriceURL($price, $variable, $product='prod_N3K5NnPyQ8O9Rb') {

      return "https://invoice.com/";

        $price = $price * 100;

        $stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET')
          );

        if($variable == true) {
        $price = $stripe->prices->create([
            'custom_unit_amount' => [
              'enabled' => true,
              'preset' => $price
            ],
            'currency' => 'aud',
            'product' => $product,
          ]);
        } else {
            $price = $stripe->prices->create([
                'unit_amount' => $price,
                'currency' => 'aud',
                'product' => $product,
              ]);
        }
    
          $price_id = $price->id;
    
          $links = $stripe->paymentLinks->create(
            [
              'line_items' => [['price' => $price_id, 'quantity' => 1]],
            ]
          );
    
        return $links->url;
    }
}
