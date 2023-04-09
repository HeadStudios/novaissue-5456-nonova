<?php

namespace App\Nova\Actions;
use Illuminate\Support\Facades\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use App\Models\Touchpoint;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Mail\MyMailGun;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Date;
use Lednerb\ActionButtonSelector\ShowAsButton;

use Laravel\Nova\Fields\Select;


class SendEmailAction extends Action
{
    use InteractsWithQueue, Queueable;
    use ShowAsButton;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
{
    $data = [$fields];
    dump("Fields passed are: ");
    dump($fields);
    $view = $fields->template;

    foreach ($models as $model) {
        $model->call_result = "Call Me Back";

        

        $model->save();

        $email = $model->contact->email;
        $stakeholderEmails = $model->contact->stakeholders->pluck('email')->toArray();
        $message = new MyMailGun($model, $fields);
        Mail::to($email)
              ->cc($stakeholderEmails)
              ->bcc('enquiries@headstudios.com.au')
              ->send($message);

        // Delete any future Touchpoint models with the air_contact_id set to $model->air_contact_id and date greater than $model->date
        Touchpoint::where('air_contact_id', $model->air_contact_id)
            ->where('date', '>', $model->date)
            ->delete();

        // Create a new Touchpoint model
        $touchpoint = new Touchpoint();

        // Set the date to $fields->wait_days days from today
        $touchpoint->date = $fields->callback_day; //now()->addDays($fields->wait_days)->toDateString();

        dump("The date after I add " . $fields->wait_days . " days to today is: " . now()->addDays($fields->wait_days)->toDateString());

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
        return [
            Select::make('Email Template', 'template')->options([
                'emails.simple' => 'Simple and Clean',
                'emails.complex' => 'Quick and Dirty'
            ])->default('emails.simple'), // Set the default option here
            Textarea::make('Message')->rows(5),
            Date::make('Callback Day')->default(now()->addDays(10)), 
        ];
    }
}
