<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use App\Models\Contact;
use App\Models\User;
use App\Models\Campaign;
use App\Models\CampaignContact;
use Hash;
use App\Hydraulics\Campaigner;
use App\Jobs\GenerateVideoSeries;



class Userea extends Action implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    public $name = 'Userea';
    

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

            GenerateVideoSeries::dispatch($model->id);

            


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
            Text::make('Name'),
            Text::make('Email'),
            Text::make('Company Name'),
            Text::make('Website URL'),
            Text::make('Mobile'),
            Image::make('Logo'),
            Image::make('Hero Image'),
            Image::make('Profile Photo')

        ];
    }
}
