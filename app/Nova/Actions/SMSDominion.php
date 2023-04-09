<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use App\Hydraulics\MMSHolder;
use App\Models\Touchpoint;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;
use App\Models\ScheduledSms;
use Propaganistas\LaravelPhone\PhoneNumber;
use Laravel\Nova\Fields\DateTime;

class SMSDominion extends Action
{
    use InteractsWithQueue, Queueable;

    public $touch; 
    public $mobile;
    public $email;
    public $account;
    public $name;

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
   
        foreach ($models as $touchpoint) {
            $contact = $touchpoint->contact;
            $mobileNumber = PhoneNumber::make($contact->mobile, 'AU')->formatE164();
    
            if (empty($fields->scheduled_at)) {
                MMSHolder::sendSingleMessage($mobileNumber, $fields->message);
            } else {
                ScheduledSms::create([
                    'contact_air_id' => $contact->air_id,
                    'message' => $fields->message,
                    'scheduled_at' => $fields->scheduled_at,
                ]);
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

        $touch = (fn(): ?Touchpoint => $request?->selectedResources()?->first())();
        $touch = $touch ?? $this->touch;

        $name = '';

        if ($touch) {


        
            $contact = $touch->contact;
        
            if (isset($this->name)) {
                $name = trim($this->name); // remove any leading/trailing white spaces
                $name = strtolower($name); // convert to lowercase
                $name = ucwords($name); // capitalize first letter of each word
                $name = explode(' ', $name, 2); // split into an array of words, max 2
                $name = $name[0]; // get the first word as the first name
                $this->name = $name; // set the first name to $this->name
              } else {
                $this->name = 'Bobby';
              }
            $this->name = isset($contact->name) ? $contact->name : '';
            $this->email = isset($contact->email) ? $contact->email : '';
            $this->account = isset($contact->account) ? $contact->account : '';
            $this->mobile = isset($contact->mobile) ? $contact->mobile : '';


            
        } else {
            $this->name = '';
            $this->email = '';
            $this->account = '';
        }

        return [
            DateTime::make('Scheduled At'),
            Select::make('Template', 'template')
            ->options([
                '1' => 'More Info',
                '2' => 'Agreement',
                '3' => 'Teaser'
            ])
            ->displayUsingLabels()
            ->rules('required'),



            Textarea::make('Message', 'message')
                ->rows(5)
                ->rules('required')->dependsOn(['template'], function (Textarea $field, $request, $formData) use($name) {
                    if (is_null($formData->template)) return;

                    if($formData->template == 1) {
                        $field->value = "Hey ".$this->name.",

Please find more info on the rent roll growth system:
https://rrdevours.monster

Case Study
https://headstudios.com.au/case_study/metrocity/

Thank you!

Kosta";
                    }

                    if($formData->template == 2) {
                        $field->value = "Hi ".$this->name.",

The agreement to get started on my rent roll growth program is in your inbox ".$this->email."  - the investment is:

$3,000
---------
5 AI videos 
5 Video Landing Pages
5 Email Sequences
Team Sales Workflow Integration
6 Week Setup (8 Week Support)

Will send agreement to your inbox ".$this->email." in the next 15 minutes - and I get to work right away putting together your branded video audit under the ".$this->account." brand so you can get a taste of what it will look like. 

Excited to get started.

Kosta";
                    }

                    if($formData->template == 3) {
                        $field->value = "Hi ".$this->name.",

A teaser to whet your appetite until the real thing:
https://rrdevours.monster/vblog/pm/rrds/your-requested-teaser";
                    }
                    
                })
        ];
    }
}
