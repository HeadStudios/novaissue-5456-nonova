<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Carbon\Carbon;
use App\Jobs\SendContractJob;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Nova\Fields\Boolean;

use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Lednerb\ActionButtonSelector\ShowAsButton;
use App\Models\Opp;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Hidden;
use Illuminate\Support\Facades\Log;

use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Markdown;

use Laravel\Nova\Fields\Number;
use Whitecube\NovaFlexibleContent\Flexible;






class OppHit extends Action
{
    use InteractsWithQueue, Queueable;
    use ShowAsButton;

    public $touch;
    
    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {

        foreach($models as $model)
        $opp = app()->make('CampMan')->oppHit($model->contact, $fields->email, $fields);
        $today = Carbon::now()->format('d/m/Y');
        SendContractJob::dispatch($opp->id, $today);

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


            Markdown::make('Email'),
            Select::make('Agreement Type', 'type')
            ->options([
                'standard' => 'Standard Pricing',
                'monthly' => 'Monthly Pricing',
            ]),

            Number::make('Period')->dependsOn(['type'], function ($field, $request, $formData) {
                if($formData->type == 'monthly') {
                    $field->show();
                    }
            })->hide(),

            Currency::make('Price')->currency('AUD')->locale('EN_au')->nullable(),

            Boolean::make('Setup Fee'),

        Currency::make('Setup Fee Amount', 'setup_fee_amount')
            ->currency('AUD')
            ->locale('EN_au')
            ->nullable()
            ->dependsOn(['setup_fee'], function ($field, $request, $formData) {
                if ($formData->setup_fee) {
                    $field->show();
                }
            })->hide(),

            

        ];
    }
}
