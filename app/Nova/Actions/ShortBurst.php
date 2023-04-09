<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Support\Facades\Http;
use Laravel\Nova\Fields\Text;
use App\Nova\Actions\Exception;

class ShortBurst extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Short the Stock';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        throw new Exception('My first Sentry error!');
        foreach ($models as $model) {
            //(new AccountData($model))->send($fields->subject);
            foreach($models as $campaign)
    {
       $namer = $campaign->campaign->subheadline;
   $campaign->shortlink = $namer;
   $campaign->save();
        /*$response = Http::post('https://webhook.site/7058c084-b629-4f76-bd4e-d42e856339fb', [
            'name' => 'Steve',
            'role' => '3 Networks?',
        ]);*/
    }
            

            //return Action::message('The stock was shorted');
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
        Text::make('Subject');
    }
}
