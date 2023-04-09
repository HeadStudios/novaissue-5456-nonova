<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Kostasmatrix\Autofiller\Autofiller;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Select;
use Waynestate\Nova\TextCopy\TextCopy;
use Illuminate\Support\Facades\Env;
use App\Models\Contact;
use Illuminate\Support\Str;

class VideoAudit extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\VideoAudit::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'Video Audit';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Contact', 'contact')->searchable()->nullable(),
            Select::make('test')
                ->options([
                    'Property Management',
                    'option2',
                ]),
            TextCopy::make('URL', function () {
                return env('APP_URL').'/audit/'.$this->permalink;
            }),
            TextCopy::make('Screenshot', 'screenshot')->truncate(15)->exceptOnForms(),
            Text::make('Permalink')->dependsOn(['contact'], function (Text $field, $request, $formData) {
                if(isset($formData->contact)) {
                    $contact = Contact::find($formData->contact);
                    $field->value = Str::slug($contact->account . "-audit-for-" . $contact->name);
                    }
            }),
            Text::make('Headline')->dependsOn(['test','contact_name', 'contact'], function (Text $field, $request, $formData) {

                if (is_null($formData->test)) return;
                if ($formData->test == 0) {
                    $contact = Contact::find($formData->contact);
                    $field->value = $contact->name.", let me show you how to add an additional 2 managements per month using a scientific formula I discovered";
                } elseif ($formData->test == 1) {
                    $field->value = "you select option2 and ".$this->subheadline;
                }



              
            }),
            Text::make('Subheadline', 'subheadline')->dependsOn(['test'], function (Text $field, $request, $formData) {
                if (is_null($formData->test)) return;
                if ($formData->test == 0) {
                    $field->value = "These are the same strategies that I have used with clients to get them results quickly, using their existing traffic";
                } elseif ($formData->test == 1) {
                    $field->value = "you select option2 and ".$this->subheadline;
                }
            }),
            Image::make('Logo URL', 'logo_url')->disk('s3'),
            Text::make('Video Thumbnail', 'v_thumbnail'),
            Text::make('Audit URL', 'audit_url'),
        ];
    }

    public static function availableForNavigation(Request $request)
    {
        //return !Gate::check('hide-resource-from-students', $request->user());
        return $request->user()->hasRole('admin');
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [
            //new Filters\ByAuditStatus,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            new Actions\ProcessizeAudit,
            new Actions\UpgradeServer,
            new Actions\TakeScreenshot
        ];
    }
}
