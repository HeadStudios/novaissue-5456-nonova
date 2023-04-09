<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Models\Contacts;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use KirschbaumDevelopment\Nova\InlineSelect;
use Laravel\Nova\Fields\HasMany;
use App\Nova\ScheduledSms;

class Contact extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Contact::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    public static $searchable = true;


    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'email',
    ];

    public static function search(\Laravel\Nova\Http\Requests\NovaRequest $request, $query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%');
    }

    public static function availableForNavigation(Request $request)
    {
        //return !Gate::check('hide-resource-from-students', $request->user());
        return $request->user()->hasRole('admin');
    }

    /*public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->where('user_id', $request->user()->id);
    } */

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable()->onlyOnForms()->nullable(true),
            Text::make('Name')->nullable(true),
            Text::make('Email')->nullable(true),
            BelongsTo::make('User', 'user', 'App\Nova\User')->hideFromIndex()->searchable()->nullable(), 
            Text::make('Country Code')->nullable(true),
            Text::make('Phone', 'mobile')->nullable(true),
            Text::make('Last Contact Date', function () {
                $lastTouchpoint = $this->touchpoints()
                    ->where('call_result', '!=', 'Voicemail')
                    ->whereNotNull('call_result')
                    ->orderBy('date', 'desc')
                    ->first();
    
                return $lastTouchpoint ? $lastTouchpoint->date->format('Y-m-d') : null;
            }),
            Text::make('Website')->nullable(true),
            Text::make('City')->nullable(true),
            Text::make('Account')->nullable(true),
            Boolean::make('MMS Unsubs', 'unsubscribed')->sortable()->nullable(true),
            Boolean::make('Email Unsubs', 'eunsubscribed')->sortable()->nullable(true),
            HasMany::make('Stakeholders', 'stakeholders', Stakeholder::class)->inline(),
            HasMany::make('Scheduled SMS', 'scheduledSms', ScheduledSms::class),
            HasMany::make('Scheduled Emails', 'scheduledEmails', ScheduledEmail::class),
            HasMany::make('Touchpoints', 'touchpoints', Touchpoint::class),
            HasMany::make('Opps', 'opps', Opps::class)

        ];
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
            new Filters\ContactUnsubscribed
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
        return [
            new Lenses\ContactsUecLens,
        ];
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
            new Actions\ShortBurst,
            new Actions\HealthyCleanse,
            new Actions\SubscriberSync,
            new Actions\SyncContactsFromAirtable,
            new Actions\SyncUnsubsFromSendPortal,
            new Actions\SendEmailAction
        ];
    }
}
