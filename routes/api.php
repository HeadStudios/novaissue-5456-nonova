<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OppsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CampaignController;
use App\Hydraulics\ImageMagic;
use App\Hydraulics\AirBooker;
use App\Models\CampaignContact;
use Illuminate\Support\Facades\Mail;
use App\Models\Contact;
use App\Models\Campaign;
use App\Models\VideoAudit;
use App\Hydraulics\Campaigner;
use App\Hydraulics\SyncMan;
use Illuminate\Support\Carbon;
use \TANIOS\Airtable\Airtable;
use Illuminate\Support\Facades\Http;



/*
|-------------- ------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('contacts/', [ContactController::class, 'update']);

Route::get('contacts/eunsubscribe/{email}', [ContactController::class, 'eunsubscribe']);

Route::post('contacts/store/', [ContactController::class, 'store']);

Route::post('/bonappetit', function(Request $request) {

    

    $e_array = $request->all();
    
    

});

Route::post('/lambda', function(Request $request) {
    $e_array = $request->all();

    // Get the relative path from the request
    $relativePath = $e_array['objectKey'];

    // Get the base URL from the environment variable
    $baseUrl = env('AWS_BASE');

    // Construct the full URL by concatenating the base URL and the relative path
    $fullUrl = $baseUrl . $relativePath;

    // Extract the campaign ID from the relative path
    preg_match('/\/(\d+)_/', $relativePath, $matches);
    $campaignId = $matches[1];

    // Update the campaign model
    $campaign = Campaign::find($campaignId);
    $campaign->tiktok_url = $fullUrl;
    $campaign->save();

    
    
    return "Anything?";
});


Route::post('/calendly', function(Request $request) {

    $booker = new AirBooker();
    $e_array = $request->all();
    
    
    
    
    
    $booker->addDateBooster($e_array["payload"]["email"], 'Date scheduled with: '.$e_array["payload"]["email"]);
    $booker->addAppointment($e_array["payload"]["email"], $e_array["payload"]["event"]);

    
    return "tap out biatch";

    $mutable = Carbon::now();

    $e_array = $request->all();

    $airtable = new Airtable(array(
        'api_key' => 'keylYErYYyR6FIbVR',
        'base'    => 'appzNOZaonMIXQNnZ'
    ));

    $new_booster = array(
        'Journey' => "3. Appointment Set",
        "Start Date/Time" => $mutable->toDateString(),
        "Notes" => "New appointment for: ".$e_array["payload"]["email"]
    );

    $new_contact = $airtable->saveContent( "Touchpoints", $new_booster );

    
    
    

    return $e_array;

});

Route::post('/assignment', [CourseController::class, 'assignment'])->name('assignment.submit');

Route::post('/vlpush', function(Request $request) {

    

    $e_array = $request->all();

    
    

    $audit = VideoAudit::where('id', $e_array["id"])->first();
    $audit->audit_url = $e_array["video"];
    $audit->v_thumbnail = $e_array["thumbnail"];
    $audit->save();

    $details = [
        'name' => 'Kosta',
        'subject' => 'YouTube Audit Ready',
        'body' => 'Your video is ready - and the URL is: '.$e_array["video"]
    ];

    Mail::to('enquiries@headstudios.com.au')->send(new \App\Mail\OppsEmail($details));

    return $audit;

});

Route::get('/push-it', function() {

    $response = Http::post('https://dev1.rrdevours.monster/api/vlpush', [
        'id' => 10,
        'video' => 'https://www.youtube.com/watch?v=BCU6pRfMeLE',
    ]);

    return $response;


});

Route::get('/check/{user_id}/{id}/{set}', [CourseController::class, 'checkit']);
Route::get('/watched/{userId}/{vlessonId}/{watched}', [CourseController::class, 'updateWatched']);
Route::get('/approve/{user_id}/{id}/{set}', [CourseController::class, 'appit']);
Route::post('/vclicker', function(Request $request) {

    $e_array = $request->all();

    dump($e_array);

    return "Done";
    

    $booker = new AirBooker();
    $mutable = Carbon::now();
    $event = '';
    if(!empty($e_array['event'])) { $event = $e_array['event']; }
    if($event == 'link_clicked') {
    $booker->addJourneyStep($mutable, $e_array['to'], 'A. Link Clicked', '*Event:LinkClick*Subject: '.$e_array['subject']."*Ender*"); 
    
    }
    if($event == 'hotlead') {
        $booker->addJourneyStep($mutable, $e_array['to'], 'E. Hot Lead', '*Event:HotLead*Subject: '.$e_array['subject']."*Ender*"); 
        
    }
    

});
Route::post('/vocus', function(Request $request) {

    $e_array = $request->all();

    
    

    //Your Rent Roll Acceleration Funnel is Ready
    if(str_contains($e_array["Subject"], "Your Rent Roll Acceleration Funnel is Ready")) {

        $email = $e_array["To"];

        $parsed = mailparse_rfc822_parse_addresses($email);

        $email = $parsed[0]["address"];

        $booker = new AirBooker();
        $mutable = Carbon::now();
        $booker->addJourneyStep($mutable, $email, '5. LP Hook', 'Landing Page Hook is a go! Direct from Mailgun');

    }


    if(str_contains($e_array["Subject"], "your rent roll accelerator video audit")) {

        
        
        $email = $e_array["To"];

        $parsed = mailparse_rfc822_parse_addresses($email);

        $email = $parsed[0]["address"];
        
        $booker = new AirBooker();
        $mutable = Carbon::now();
        $booker->addJourneyStep($mutable, $email, '4. Audit Sent', 'Audit is a go - this is from Mailgun');

    }

    if($e_array["Subject"] == "rent roll growth systematisation [video]") {

        $email = $e_array["To"];

        

        $mutable = Carbon::now();
        $booker = new AirBooker();
        $mutable = Carbon::now();
        $booker->addJourneyStep($mutable, $email, '2. Props Sent', 'Original props sent');

        



    }

    

});

Route::get('/carboner', function() {

    
$mutable = Carbon::now();
$airtable = new Airtable(array(
    'api_key' => 'keylYErYYyR6FIbVR',
    'base'    => 'appzNOZaonMIXQNnZ'
));

$params = array(
    "filterByFormula" => "DATESTR({Date})='".$mutable->toDateString()."'",
    "maxRecords" => 1
);

$request = $airtable->getContent( 'Daily Hits', $params);
$array = $request->getResponse();
$record_id = $array["records"][0]->id;
// Create an array with all the fields you want 
$new_contact_details = array(
    'Notes' => "ExitSign is a go",
    "Type" => "Booster Shot",
    'Daily Hit'     => array($record_id)
);

// Save to Airtable
$new_contact = $airtable->saveContent( "Touchpoints", $new_contact_details );
return $new_contact;


});

Route::post('/file-url', function (Request $request) {

    $path = $request->filepath;
    $baseurl = URL::to('/');
    $imgurl = Storage::disk('s3')->url($path);
    return response()->json([
        'path' => $imgurl,
        'baseurl' => $baseurl,
        'realone' => env('AWS_BASE')
        
    ]);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('/broz/{id}', function ($id) {
    //return view('braz', ['name' => 'Bromantha', 'age' => $id]);
    $return = 'Numbers are: '.$id.'boooiiiii';
    return response($return, 200)
                  ->header('Content-Type', 'application/json');
});

Route::get('/invoicesend', [OppsController::class, 'homie']);

Route::get('/imagemagic', [CampaignController::class, 'grow']);

Route::get('/downsize', function() {

    Campaigner::downgradeServer();
    
});

Route::get('/shortit', function() {
    $response = Http::withHeaders([
        'Accept' => 'application/json',
        'Authorization' => 'sk_7D26vBocMbHyPvUL'
    ])->post('https://api.short.io/links', [
        'allowDuplicates' => false,
        'domain' => 'showme.headstudios.com.au',
        'originalURL' => 'https://ghostbusters.com',
        'path' => 'for-ghostbuster'
    ]);

    $shortUrl = $response['shortURL'];

    return $shortUrl;
    
});



Route::post('/drawpic/{name}', [CampaignController::class, 'imageCreate']);

Route::get('/mobiler', function() {

    $mobile = $_GET['mobile'];
    $wozers = Contact::where('mobile', $mobile)->first();
    $wozers->unsubscribed = 1;
    $wozers->save();
    return $wozers;

});

Route::post('/webhooker', function() {

    $path = $_POST['path'];
    $camp_c = CampaignContact::where('shortlink', 'like', '%'.$path.'%')->first();
    $camp_c->clicks = (int)$camp_c->clicks++;
    $num = (int)$camp_c->clicks;
    $num = $num + 1;
    $camp_c->clicks = $num;
    $camp_c->save();

});


