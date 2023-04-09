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
use \TANIOS\Airtable\Airtable;
use Illuminate\Support\Carbon;
use GuzzleHttp\Client;



class AirBooker {

    public $api = 'keylYErYYyR6FIbVR';
    public $base = 'appzNOZaonMIXQNnZ';
    public $airtable;
    public $token;
    public $event_ref;

    public function __construct() {

        $this->airtable = new Airtable(array(
            'api_key' => env('AIRTABLE_TOKEN'),
            'base'    => $this->base
        ));
        $this->token = env('AIRTABLE_TOKEN');
        
        $this->event_ref = ['hot_lead' => 'E. Hot Lead', 'event_ref_2' => 'hooyakasha', 'event_ref_3' => 'mookayasha'];

    }

    public function getRecords($view, $table='Contact') {
        $airtable = $this->airtable;
        

        $params = array(
            "view" => $view,
            "maxRecords" => 5000,
            "pageSize" => 100,
        );
        
        return $airtable->getContent( $table, $params);
    }

    public function getRecordsFromView($view, $table='Contact') {

        $request = $this->getRecords($view, $table);

        $records = [];

        do {
            $response = $request->getResponse();
                $records[] = $response[ 'records' ];       
            }
        while( $request = $response->next() );

        return $records;

    }

    public function getSubscribers() {
        $airtable = $this->airtable;
        

        $params = array(
            "view" => "Hit Lister Sub",
            "maxRecords" => 5000,
            "pageSize" => 100,
        );
        
        return $airtable->getContent( 'Contact', $params);
    }

    public function booya($ref) {
        return $this->event_ref[$ref];
    }

    public function addAppointment($email, $event_url) {

        $response = Http::withToken($this->token)->get($event_url);
        
        
        $start_time = new Carbon($response["resource"]["start_time"]);
        $start_time->setTimezone('Australia/Sydney');
        $string_start = $start_time->toDateTimeString();
        //return $string_start;
        $end_time = $start_time->addMinutes(20);
        $end_time->setTimezone('Australia/Sydney');
        $string_end = $end_time->toDateTimeString();

        $recordId = $this->getContactIDByEmail($email);
        

        $new_booster = array(
            
            "Type" => "Meeting",
            "Contact" => array($recordId),
            "Start Date/Time" => $string_start,
            "End Date/Time" => $string_end,
            "Notes" => "Meeting for ".$email."Check your calendar for why this fails"

        );

        

        $air = $this->airtable;

        $new_contact = $air->saveContent( "Touchpoints", $new_booster );
        
        

    }

    public function addDateBooster($email, $notes) {

        $recordId = $this->getContactIDByEmail($email);

        $mutable = Carbon::now();
        //return $string_start;

        

        $new_booster = array(
            'Contact' => array($recordId),
            'Journey' => "3. Appointment Set",
            "Start Date/Time" => $mutable->toDateTimeString(),
            "Notes" => $notes
        );

        $air = $this->airtable;
    
        $new_boost = $air->saveContent( "Touchpoints", $new_booster );
    }

    public function addJourneyStep(Carbon $datetime, $email, $step, $note) {

        $email = self::extractEmail($email);

        

        $rec_id = $this->getContactIDByEmail($email);

         

        $new_booster = array(
            "Contact" => array($rec_id),
            'Journey' => array($step),
            "Start Date/Time" => $datetime->toDateTimeString(),
            "Notes" => $note
        );

        
        

        $air = $this->airtable;
    
        $next_step = $air->saveContent( "Touchpoints", $new_booster );



    }

    public static function extractEmail($string) {
        // Use the regular expression to match the email address
        preg_match('/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}/i', $string, $matches);
        // Return the first match (the email address)
        return $matches[0];
      }

    

    public function getContactIDByEmail($email) {

        

        $params = array(
            "filterByFormula" => "{Email}='".$email."'",
            "maxRecords" => 1
        );

        $request = $this->airtable->getContent( 'Contact', $params);
        $array = $request->getResponse();
        
        
        return $array["records"][0]->id;
        }

        public function unsubscribeContactFromEmail($email) {
            $this->updateAirtableContact($email, ['EUNSUB' => true]);
        }

        public function unsubscribeContactFromMMS($email) {
            $this->updateAirtableContact($email, ['MMSUNSUB' => true]);
        }



        public function updateAirtableContact($email, $fields = []) {
            $defaultFields = [
                "Email" => $email
            ];
            $fields = array_merge($defaultFields, $fields);


            $data = [
                "performUpsert" => [
                    "fieldsToMergeOn" => [
                        "Email"
                    ]
                ],
                "records" => [
                    [
                        "fields" => $fields
                    ]
                ]
            ];
        
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.env('AIRTABLE_TOKEN'),
                'Content-Type' => 'application/json'
                ])->patch('https://api.airtable.com/v0/appzNOZaonMIXQNnZ/Contact', $data);

                
                
        
            return $response;
        }

        public function getContactByID($id) {

            $client = new Client();

            $response = $client->get("https://api.airtable.com/v0/appzNOZaonMIXQNnZ/Contact/$id", [
                'headers' => [
                    'Authorization' => 'Bearer '.env('AIR_KEY'),
                ]
            ]);

            $json = json_decode($response->getBody());

            $fields = $json->fields;

            // Now you can use the value of $fields in your code
            // For example, you can return it as a JSON response
            return response()->json($fields);

        }



    }



