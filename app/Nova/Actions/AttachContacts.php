<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Laravel\Nova\Fields\Select;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\OppsController;
use App\Http\Controllers\CampaignController;

use Illuminate\Support\Facades\DB;

use App\Models\Contact;
use App\Models\CampaignContact;
use App\Jobs\ProcessAndAttach;
use App\Jobs\LocalJob;
use App\Jobs\FreshAttacherProcess;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Log;

use App\Hydraulics\SMSPrep;
use Laravel\Nova\Fields\Number;

class AttachContacts extends Action implements ShouldQueue
{

    use InteractsWithQueue, Queueable;

    public $name = 'Attach Zesiy Contacts';

    public function __construct()
    {
        $this->queue = env('QUEUE_NAME');
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
           

            $fields = $fields->toArray();
            $var = 0;
            $limit = 1;
            Contact::where(function ($query) {
                $query->where('unsubscribed', 0)
                      ->orWhereNull('unsubscribed');
            })
            ->where('name', 'like', '%test%')
            ->chunk(3, function ($contacts) use(&$var, $limit, $model, $fields) {
                if($var > $limit) { return; }
                
                LocalJob::dispatch($model->id, $contacts, $fields)->onQueue(env('QUEUE_NAME'));
                $var++;
            });
            /*
            $contacts->chunk(8, function ($chunk) {
                
                
                
            });

            /*$contacts->chunk(8, function ($chunk) {
                
                
                
            });

            

            //
            //

            //LocalJob::dispatch($model->id, $contacts, $fields)->onQueue(env('QUEUE_NAME'));

            /*
            $contacts->chunk(8, function ($contacts) use($model, $fields) {
                
                LocalJob::dispatch($model->id, $contacts, $fields)->onQueue()
            }); */
        }

        return Action::message('Coopa');

            //
            //
                
            

            


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
            Number::make('Left')->min(0),
            Number::make('Top')->min(0),
            Number::make('Size')->min(0),
        ];
    }
}