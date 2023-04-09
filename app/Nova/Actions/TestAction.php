<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\Contact;
use Laravel\Nova\Fields\Number;

class TestAction extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {

        //$contacts = Contact::inRandomOrder()->take(10)->get();
        foreach($models as $model) {

        
        $contacts = Contact::where(function ($query) {
            $query->where('unsubscribed', 0)
            ->orWhereNull('unsubscribed');
            })
            ->inRandomOrder()
            ->limit(15)
            ->get();
       foreach($contacts as $contact) {
            $arra = $fields->toArray();
            
            
            
        }
        }

        return Action::message("Coopa");
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
