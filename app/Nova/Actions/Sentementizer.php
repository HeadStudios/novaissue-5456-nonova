<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class Sentementizer extends Action
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
        foreach ($models as $model) {
            dump("Updating sentiment for...");
            dump($model->contact);

            $model->contact->update(['sentiment' => $fields->vibe]);
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
            Select::make('Vibe')
                ->options([
                    'ambivelent' => 'Ambivelent',
                    'angry' => 'Angry',
                    'starry' => 'Starry',
                    'onpoint' => 'On Point',
                    'moneyface' => 'Money On Point',
                    'stressed' => 'Stressed',
                ])
                ->displayUsingLabels()
                ->rules('required'),
        ];
    }
}
