<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Select;
use App\Models\Touchpoint;
use App\Mail\MyMailGun;
use Carbon\Carbon;
use App\Models\Contact;
use App\Jobs\SequenceSend;
use Laravel\Nova\Fields\Markdown;
use App\Models\Sequencer;
use Laravel\Nova\Http\Requests\NovaRequest;
use Lednerb\ActionButtonSelector\ShowAsButton;

class SendSequence extends Action
{
    use InteractsWithQueue, Queueable;
    use ShowAsButton;

    public $touch; 

    public function __construct(Touchpoint $touch = null) {

        $this->touch = $touch;

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

        foreach($models as $model) {

            Touchpoint::where('air_contact_id', $model->air_contact_id)
                ->where('date', '>', $model->date)
                ->delete();
        
            $scheduledAt = $fields->scheduled_at ? Carbon::parse($fields->scheduled_at) : now();
            $contact = $model->contact;
        
            dump("So we hit the actio and the contact we throwing is: ");
            dump($contact);
        
            SequenceSend::dispatch($contact, $fields, $scheduledAt)->onQueue('mail');
        
            $touchpoint = new Touchpoint();
        
            // Set the date to the scheduledAt date without the time part
            $touchpoint->date = $scheduledAt->toDateString();
        
            // Set the air_contact_id to the associated AirContact's id
            $touchpoint->air_contact_id = $model->air_contact_id;
        
            // Save the new Touchpoint model
            $touchpoint->save();
        
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

        $touch = (fn(): ?Touchpoint => $request?->selectedResources()?->first())();
        $touch = $touch ?? $this->touch;
        $name = 'Brian';
        $email_array = \App\Models\Sequencer::all()->pluck('name', 'id')->toArray();
        //dump($email_array);
        /*if (!isset($touch->contact->user->hero_image)) {
            foreach ($email_array as $key => $value) {
                if ($value === 'BDM Sequence') {
                    unset($email_array[$key]);
                    break;
                }
            }
        }

        if ($touch !== null && $touch->contact !== null && $touch->contact->user !== null && $touch->contact->user->campaigns !== null) {
            dump("The amount of campaigns for ".$touch->contact->name." is: ");
            dump(count($touch->contact->user->campaigns));
            dump("The first oen for what it's worth is: ");
            dump($touch->contact->user->campaigns->first());

        }

        if ($touch !== null && $touch->contact !== null && $touch->contact->user !== null && isset($touch->contact->user->campaigns) && (count($touch->contact->user->campaigns) < 3)) {
            foreach ($email_array as $key => $value) {
                if ($value === 'Video AI Sequence') {
                    unset($email_array[$key]);
                    break;
                }
            }
        }*/
        


        return [
            Select::make('Sequence')
            ->options($email_array)
            ->displayUsingLabels()
            ->rules('required'),
            Markdown::make('Intro Text', 'intro_text'),
            Boolean::make('Test', 'test'),
            DateTime::make('Scheduled At', 'scheduled_at'),


        ];
    }
}
