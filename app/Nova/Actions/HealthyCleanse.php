<?php

namespace App\Nova\Actions;

use Brightspot\Nova\Tools\DetachedActions\DetachedAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use App\Models\Contact;
use Propaganistas\LaravelPhone\PhoneNumber;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use App\Hydraulics\AirBooker;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Support\Facades\Http;
use App\Jobs\SendPortalUnsubscribe;

class HealthyCleanse extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Healthy Cleanse';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $bookman = new AirBooker();
        $request = $bookman->getRecords();
        $air_recs = [];
        do {
            $response = $request->getResponse();
            foreach($response['records'] as $record) {
                $air_recs[] = $record;
                
            }
            
        }
        while( $request = $response->next() );

       // Cache the $contacts collection in memory
       
       
       $contacts = Contact::all();
        $cachedContacts = $contacts->keyBy('mobile');

        $rchunks = array_chunk($air_recs, 60);

        foreach($rchunks as $chunk) {

            SendPortalUnsubscribe::dispatch($chunk);

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

        ];
    }
}
