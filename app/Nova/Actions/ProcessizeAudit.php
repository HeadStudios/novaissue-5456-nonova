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
use App\Hydraulics\Campaigner;

class ProcessizeAudit extends Action implements ShouldQueue
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
        $queue = 1;
        $total = count($models);

        Campaigner::upgradeServer();
        
        foreach($models as $audit) {

        sleep(3);

        Http::post('http://198.199.67.139/mpeger/public/api/film-school', [
            'audit_id' => $audit->id,
            'client_logo' => $audit->logo_url,
            'client_company' => $audit->permalink,
            'client_name' => $audit->contact_name,
            'mp4_audit' => $audit->audit_url,
            'jobs_total' => $total,
            'current_job' => $queue,
        ]); 
        
        $queue += 1;
        
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
        return [];
    }
}
