<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Select;
use App\Jobs\DrippySequence;

class SendADrippy extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Send a Drippy';

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
        if($fields->fake == 'Y') { 

            DrippySequence::dispatch($model->id, false);

        } else {
            DrippySequence::dispatch($model->id,true);
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
            Select::make('Fake')->options([
                'Y' => 'Yes, keep it fake',
                'N' => 'We going real'
            ])
        ];
    }
}
