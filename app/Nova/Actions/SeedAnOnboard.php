<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\Checklist;
use App\Models\CheckTemplate;
use Laravel\Nova\Fields\Number;

class SeedAnOnboard extends Action
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
        foreach($models as $model) {
            //

            //$user_id = 48;

            $check = CheckTemplate::where('id', 1)->first();
            //$array = $check->check_template->toArray();
            //
            $array = json_decode($check->check_template, true);
            //
            foreach($array as $item) {
                $check = new Checklist;
                $check->name = $item['attributes']['name'];
                $check->description = $item['attributes']['description'];
                $check->status = 0;
                $check->vlesson_id = $item['attributes']['video_id'];
                $check->user_id = $model->id;
                $check->save();
            }

            /*
            foreach($check->check_template as $item) {
                
            }
            */
            //

            /*

            $array = $check->check_template->toArray();

            

            foreach($array as $item) {
                $check = new Checklist;
                $check->name = $item['name'];
                $check->description = $item['description'];
                $check->status = 0;
                $check->vlesson_id = $item['video_id'];
                $check->user_id = $user_id;
                $check->save();
                return $item['name'];
            }
            */



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
            Number::make('Onboard ID'),
        ];
    }
}
