<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Jobs\SendAPacket;

use App\Hydraulics\MMSHolder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Laravel\Nova\Fields\DateTime;

use App\Models\Contact;
use App\Models\CampaignContact;

use Propaganistas\LaravelPhone\PhoneNumber;

class SendMMS extends Action implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $name = 'Send a Message';

    public function __construct()
  {
      $this->connection = 'redis';
      //$this->queue = 'emails';
  }

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach($models as $model) {

            $carbon = new Carbon($fields->schedule_at);

            

            

            $contacts = $model->campaigncontacts()->get();

            foreach($contacts as $contact) {

                $person = Contact::where('id', $contact->contacts_id)->first();
                if($contact->sent != 1) {

                $aws_base = 'https://rent-roll-devour-bucket-a1.s3.ap-southeast-2.amazonaws.com/';

                $baseurl = URL::to('/');
                $url = $baseurl.'/api/file-url';
                try {
                $phone = PhoneNumber::make($person->country_code.$person->mobile, 'AU')->formatE164(); 
                dump("Full mobile is: ");
                dump($phone);
                } catch(\Exception $e) {
                    
                    
                    
                    
                }
        
        

                $image = $contact->mms_image;
                $full_path = $aws_base.$image;

                if($image != NULL) {
                $imgurl = Storage::disk('s3')->url($image); }
                else {
                    $imgurl = '';
                }
                
                
                
                SendAPacket::dispatch($phone, $contact->mms_msg, '', $contact->id)->delay($carbon);
                if($contact->mms_image != NULL) {
                SendAPacket::dispatch($phone, '', $imgurl, $contact->id)->delay($carbon); }

                } else {
                    
                }

            }
            

        }
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [

            DateTime::make('Schedule At'),

        ];
    }
}
