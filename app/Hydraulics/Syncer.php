<?php

namespace App\Hydraulics;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Models\Opps;
use App\Models\User;
use App\Models\SendportalSubscriber;
use App\Models\Campaign;
use App\Jobs\SendAPacket;
use App\Models\Checklist;
use App\Models\Contact;
use Propaganistas\LaravelPhone\PhoneNumber;
use App\Hydraulics\AirBooker;
use App\Models\Vlesson;
use \TANIOS\Airtable\Airtable;
use Illuminate\Support\Carbon;



class Syncer {

    protected $airbooker;
    protected $eunsubs;
    protected $mmsunsubs;

    public function __construct() {
        
        //$this->airbooker = new AirBooker();
    }

    public function syncAirtableESubsFromAirTable() {

        $air = $this->airbooker;
        $subs_pgs = $air->getRecordsFromView("ELIST");
        foreach ($subs_pgs as $pg) {
            foreach($pg as $record) {
            $this->addOrUpdateSendportalSub($record->fields->Email, $record->fields->First);
            
            
            
            
            }


        }

    }

    

    public function syncAirtableUnsubsToSendPortal() {

        $air = $this->airbooker;
        $eunsubs = $air->getRecordsFromView("EUNSUB");

        $sendportal = SendportalSubscriber::all();


        foreach ($eunsubs as $record) {
            // Check if the record exists in the collection
            if (!$sendportal->contains('email', $record->fields->Email)) {

                $this->addOrUpdateSendportalUnsub($record->fields->Email, $record->fields->{'Full Name'});
                
                
            }
        }

    }

    public function syncAirtableMMSUnsubsToSendPortal() {

        $air = $this->airbooker;
        $mmsunsubs = $air->getRecordsFromView("MMSUNSUB");

        $contacts = Contact::whereNull('unsubscribed')->orWhere('unsubscribed', 0)->get();


        foreach ($mmsunsubs as $record) {
            
            $mobile = PhoneNumber::make($record->fields->phone, 'AU')->formatE164();  
            
            if ($contacts->contains('mobile', $mobile)) {

                $this->addOrUpdateContactMMSUnsub($mobile);
                
                
                
            }
        }

    }

    protected function pullMMSUnsubscribesFromAirTable() {

        $request = $bookman->getRecordsFromView("EUNSUB");


    }

    protected function pullEUnsubsFromAirTable() {

        $request = $bookman->getRecords("EUNSUB");


    }

    protected function addOrUpdateSendportalUnsub($email, $first_name) {
        $subscriber = SendportalSubscriber::updateOrCreate(
          ['email' => $email],
          ['first_name' => $first_name, 'workspace_id' => 1, 'unsubscribed_at' => Carbon::now()]
        );
      }

      protected function addOrUpdateSendportalSub($email, $first_name) {
        $subscriber = SendportalSubscriber::updateOrCreate(
          ['email' => $email],
          ['first_name' => $first_name, 'workspace_id' => 1]
        );
      }

      protected function addOrUpdateContactMMSUnsub($phone) {
        
        $subscriber = Contact::updateOrCreate(
          ['mobile' => $phone],
          ['unsubscribed' => 1]
        );
      }

      public function syncNewContactsFromAir(AirBooker $air) {

        // Filter records as necessary (e.g. only mobiles)
        $records = $air->getRecordsFromView("Hit Lister Sub");
        $records = array_merge(...$records);
        $filtered = collect($records)->filter(function ($record) {
            try {
                $phone = PhoneNumber::make($record->fields->phone, 'AU');
                if($phone->getType() == 'mobile' && isset($record->fields->Email) && isset($record->fields->{'Full Name'})) { return true; } else { return false; }
                
        
                //return $phone->getCountryCode() === '61' && strpos($phone->getRawNumber(), '+614') !== false;
            } catch (\Exception $e) {
                // If the PhoneNumber::make() method fails, filter out the record.
                return false;
            }
        });
        
        // Push each record to the Contact model

        foreach($filtered as $record) {
            $data = [];

            if (isset($record->fields->Email)) {
                $data['email'] = $record->fields->Email;
            }
            if (isset($record->fields->{'Full Name'})) {
                $data['name'] = $record->fields->{'Full Name'};
            }
            if (isset($record->fields->phone)) {
                $data['mobile'] = $record->fields->phone;
            }
            if (isset($record->fields->Website)) {
                $data['website'] = $record->fields->Website;
            }
            if (isset($record->fields->Account)) {
                $data['account'] = $record->fields->Account;
            }

            Contact::updateOrCreateContact($data);
            SendportalSubscriber::updateOrCreateSubscriber($data);

        }


        return 'Done son';
        
        
        do {
            $response = $request->getResponse();
            var_dump( $response[ 'records' ] );
        }
        while( $request = $response->next() );
      }

      public function syncContactsFromAirTable() {

        $air = $this->airbooker;
        $air_contacts = $air->getRecordsFromView("Hit Lister Sub");
        $data = [];
        $x = 0;
        
        foreach ($air_contacts as $air_pg) {
           
            
            foreach($air_pg as $record) {

                
               
                
                //
                if(isset($record->fields->Email) && isset($record->fields->{'Full Name'})) {
                    
                    $data['name'] = $record->fields->{'Full Name'};
                    
                    $email = $record->fields->Email;
                    
                if(isset($record->fields->EUNSUB)) {
                    $data['eunsubscribed'] = 1;
                }
                if(isset($record->fields->MMSUNSUB)) {
                    $data['unsubscribed'] = 1;
                }

                if(isset($record->fields->phone)) {

                    try {
                        $data['mobile'] = PhoneNumber::make($record->fields->phone, 'AU')->formatE164();
                    } catch (\libphonenumber\NumberParseException $e) {
                        
                        continue;
                    } catch (\Propaganistas\LaravelPhone\Exceptions\NumberParseException $e) {
                        
                        continue;
                    }
                
                }
                if($email == 'bobby.junior@gmail.com') {
                    
                }

                $this->addOrUpdateContact($email, $data);
                
                $x = $x + 1;


                }
                //
                //
                // MMSUNSUB
                // EUNSUB
                //$this->addOrUpdateSendportalSub($record->fields->Email, $record->fields->First);
            
                //
                //
              
            
            }

        }

    }

      protected function addOrUpdateContact($email, $data) {
        $subscriber = Contact::updateOrCreate(
            ['email' => $email],
            array_merge($data, ['author_id' => Auth::id()])
          );
      }

      public function alltherecords() {
        $airbooker = new AirBooker();
        $batches = $airbooker->getRecordsFromView('Hit Lister Sub');
        foreach ($batches as $batch) {
          foreach($batch as $record) {
           // 
           if(isset($record->fields->Email) && isset($record->fields->{'Full Name'})) {
            $data['name'] = $record->fields->{'Full Name'};
                
                $email = $record->fields->Email;
                if($record->fields->Email == 'bobby.junior@gmail.com') {
                    
                }
                
                
            if(isset($record->fields->EUNSUB)) {
                $data['eunsubscribed'] = 1;
            }
            if(isset($record->fields->MMSUNSUB)) {
                $data['unsubscribed'] = 1;
            }
            if(isset($record->fields->phone)) {

                try {
                    $data['mobile'] = PhoneNumber::make($record->fields->phone, 'AU')->formatE164();
                } catch (\libphonenumber\NumberParseException $e) {
                    
                    break;
                } catch (\Propaganistas\LaravelPhone\Exceptions\NumberParseException $e) {
                    
                    break;
                }
            
            }
          
        }
            
        }

        
      }

}

    

        public function SyncUnsubsFromSendPortal()
        {
            $subscribers = SendportalSubscriber::whereNotNull('unsubscribed_at')->get();
            foreach($subscribers as $subscriber) {
                $email = $subscriber->email;
                $fields = ['EUNSUB' => true];
                $air = $this->airbooker;
                $air->updateAirtableContact($email, $fields);
            }
        }

}


