<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use AshAllenDesign\ShortURL\Events\ShortURLVisited;
use App\Models\CampaignContact;
use App\Models\Contact;
use App\Hydraulics\AirBooker;
use Illuminate\Support\Carbon;

class PhoneMessageLinkClicked
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    public $airbooker;
    public function __construct()
    {
        $this->airbooker = new AirBooker;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ShortURLVisited  $event
     * @return void
     */
    public function handle(ShortURLVisited $event)
    {
        
        
        $shortURL = $event->shortURL;
        $message = CampaignContact::where('shortlink', 'like', '%'.$shortURL->url_key.'%')->first();
        if($message) {
            
            //
            $message->click();
            $email = Contact::find($message->contacts_id)->email;
            
            $this->airbooker->addJourneyStep(Carbon::now(), $email, 'A. Link Clicked', 'SMS Campaign Clicked');
            //
        }
    }
}
