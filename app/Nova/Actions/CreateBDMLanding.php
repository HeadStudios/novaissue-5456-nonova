<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use App\Jobs\ScreenshotModel;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Lednerb\ActionButtonSelector\ShowAsButton;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\Image;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class CreateBDMLanding extends Action
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
        foreach($models as $model) {
        
        $company_logo = $fields->company_logo;
        $profile_image = $fields->profile_image;

        $logo = $company_logo->store('images/bdm');
        $profile = $profile_image->store('images/bdm');

        //dump("The path to the land is: ");
        //dump($path);

        $user = User::create([
            'name' => $fields->name,
            'email' => $fields->email,
            'mobile' => $fields->mobile,
            'password' => Hash::make('password78'),
            'company_logo' => $logo,
            'company_name' => $fields->company_name,
            'contacts_id' => $model->contact->id,
            'address' => $fields->address,
            'website_url' => $fields->website_url,
            'company' => $fields->company_name,
            'area' => $fields->area,
            'profile_image' => $profile,
            'hero_image' => $profile,
            'company_permalink' => $fields->company_permalink
        ]);

        $model->contact->user()->associate($user);
        dump("So... ");
        $model->contact->save();

        dump("Read this user for 5 seconds: ");
        dump($user);
        sleep(5); // pause execution for 5 seconds


        //$screenshot_url = app()->make('CampMan')->screenshotModel($user);
        ScreenshotModel::dispatch($user)->onQueue('mail');

        }


    
        // Generate a unique filename for the uploaded file
        //$filename = uniqid('logo_') . '.' . $company_logo->getClientOriginalExtension();
        
        // Store the uploaded file on S3
        //$path = Storage::disk('s3')->putFileAs('videos', $company_logo, $filename);
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
            Text::make('Website URL'),            
            Image::make('Company Logo'),
            Image::make('Profile Image'),
            Image::make('Hero Image'),
            Text::make('Mobile'),
            Text::make('Company Permalink'),
            Text::make('Company Name'),
            Textarea::make('Address'),
            Text::make('Area')
        ];
    }
}
