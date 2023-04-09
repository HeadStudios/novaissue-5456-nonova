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
use Laravel\Nova\Fields\Select;

use App\Hydraulics\Campaigner;
use DigitalOceanV2\Adapter\GuzzleAdapter;

use DigitalOceanV2\Client;
use DigitalOceanV2\Exception\HttpException;

class UpgradeServer extends Action
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
        if ($fields->operation === 'upgrade') {
            dump("Upgrading server from the job");
            Campaigner::upgradeServer();
        } elseif ($fields->operation === 'downgrade') {
            dump("Downgrading server from the job");
            Campaigner::downgradeServer();
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
            Select::make('Operation', 'operation')
                ->options([
                    'upgrade' => 'Upgrade Server',
                    'downgrade' => 'Downgrade Server',
                ])
                ->rules('required')
                ->displayUsingLabels(),
        ];
    }

}
