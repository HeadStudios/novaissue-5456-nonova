<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Hydraulics\Syncer;
use Brightspot\Nova\Tools\DetachedActions\DetachedAction;


class SyncUnsubsFromSendPortal extends DetachedAction
{
    use InteractsWithQueue, Queueable;

    public function label()
    {
        return __('Sync Unsubs from SendPortal');
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
        $syncer = new Syncer;
        $syncer->SyncUnsubsFromSendPortal();
        //SyncUnsubsFromSendPortal
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
