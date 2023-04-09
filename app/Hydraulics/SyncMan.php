<?php

namespace App\Hydraulics;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Models\Opps;
use App\Hydraulics\AirBooker;
use App\Hydraulics\Syncer;
use App\Models\User;
use App\Models\Campaign;
use App\Models\Contact;
use App\Jobs\SendAPacket;
use App\Models\Checklist;
use App\Models\Vlesson;
use \TANIOS\Airtable\Airtable;
use Illuminate\Support\Carbon;
use GuzzleHttp\Client;



class SyncMan {

    protected $booker;
    protected $air_client;
    protected $syncer;

    public function __construct(Airbooker $air_client, Syncer $syncer) {

        $this->booker = $air_client;
        $this->syncer = $syncer;

    }

    public function syncAirContacts() {
        $records = $this->syncer->syncNewContactsFromAir($this->booker);
        return $records;
    }

    public function eunsubscribe($email) {
        $this->booker->unsubscribeContactFromEmail($email);
        $contact = Contact::where('email', $email)->first();
        if ($contact) {
            $contact->update(['unsubscribed' => 1]);
        }

    }

    public function smsunsubscribe($email) {
        $this->booker->unsubscribeContactFromMMS($email);
        $contact = Contact::where('email', $email)->first();
        if ($contact) {
            $contact->unsubscribed = 1;
            $contact->save();
        }


    }

    public function dumpa() {
        
    }

    public function syncByEmail($email) {

        $contact_id = $this->booker->getContactIDByEmail($email);
        if($contact_id) {
            $fields = $this->booker->getContactByID($contact_id);
            
            
            $fields = $fields->getData();
            
            

            
            if($fields->{'Full Name'}) {
                
                
                $contact = Contact::where('email', $email)->first();
                    if ($contact) {
                        $contact->name = $fields->{'Full Name'};
                        
                        $contact->save();
                    }

            }
        }

    }



}