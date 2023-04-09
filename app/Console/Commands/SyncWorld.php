<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Contact;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Support\Facades\DB;
use App\Hydraulics\MMSHolder;
use Illuminate\Support\Collection;


class SyncWorld extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'syncworld';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync the truth';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $syncman = app()->make('SyncMan');

        $syncman->syncAirContacts();

        $this->info('Watch a nigga come up!');
        $records = DB::connection('remote_mysql')
    ->table('Message')->where('status', 'Received')
    ->where(function($query) {
        $query->where('message', 'regexp', '(?i)\bStop\b')
        ->orWhere('message', 'regexp', '(?i)\bUnsubscribe\b')
        ->orWhere('message', 'regexp', '(?i)\bRemove\b');
    })->get();

        if($records instanceof Collection) {
            $this->info("Yes we have a collection, let's gooo!");
        }

        $contacts = Contact::all()->map(function ($contact) {
            try { $contact->mobile = PhoneNumber::make($contact->mobile, 'AU')->formatE164(); } catch(\Exception $e) { return; }
            return $contact;
        });

        $records = $records->map(function ($record) use($contacts, $syncman) {
            try {$record->number = PhoneNumber::make($record->number, 'AU')->formatE164(); } catch(\Exception $e) { return; }
            $matchingContacts = $contacts->where('mobile', $record->number)->first();
    
            if ($matchingContacts) {
                //
                
                $syncman->smsunsubscribe($matchingContacts->email);
            }
            return $record;
        });

        

        

        /*$realMcqueen = $records->each(function($item, $key) use($syncman) {
            
            
            
            $syncman->smsunsubscribe($item->email);
            $this->info("Just sent Airtable for ".$item->name);

        }); */

        //


    
        //



   


        if($contacts instanceof Collection) {
            $this->info("Even the contacts are a collection!");
        }

        $this->info('Hundred million dollars!');

        /*foreach($records as $record) {
            if(!ctype_alpha($record->number)) {

                try {
                    $remote_mob = PhoneNumber::make($record->number, 'AU')->formatE164();  
                    } catch(\Exception $e) {
                        continue;        
                    }

                    foreach($contacts as $contact) {
                        try {
                        $local_mob = PhoneNumber::make($contact->mobile, 'AU')->formatE164(); } 
                        catch(\Exception $e) { continue; }
                        if($remote_mob == $local_mob) {
                            //$contact->update(['unsubscribed' => 1]);
                            $this->info("We have just unsubscribed ".$contact->name);
                            //MMSHolder::unsubscribeThem($remote_mob, $contact->name);
                        }
                    }

            
            
        }
    } */

    
 }
}


