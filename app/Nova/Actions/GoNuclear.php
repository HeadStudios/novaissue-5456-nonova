<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\Contact;
use App\Models\SendportalSubscriber;


class GoNuclear extends Action
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
        foreach ($models as $touchpoint) {
            $touchpoint->call_result = "Not Interested";
            $touchpoint->save();
            // Step 1: Update the related Contact model
            $contact = $touchpoint->contact;
            $contact->unsubscribed = 1;
            $contact->eunsubscribed = 1;
            $contact->save();

            // Step 2: Update the SendPortalSubscriber model
            $subscriber = SendportalSubscriber::where('email', $contact->email)->first();
            if ($subscriber) {
                $subscriber->unsubscribed_at = now();
                $subscriber->unsubscribe_event_id = 4;
                $subscriber->save();
            }
        }

        return Action::message('The GoNuclear action has been executed successfully.');
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
