<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Image;
use Whitecube\NovaFlexibleContent\Flexible;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\BelongsTo;
use Pavloniym\ActionButtons\ActionButton;


class Opps extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Opps::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','company'
    ];

    public static function availableForNavigation(Request $request)
    {
        //return !Gate::check('hide-resource-from-students', $request->user());
        return $request->user()->hasRole('admin');
    }

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
            Date::make('Date'),
            BelongsTo::make('Contact')->searchable(),
            Text::make('Name')->nullable(),
            Text::make('Company')->nullable(),
            Image::make('Client Logo')->disk('s3')->nullable(),
            Text::make('Email')->nullable(),
            Text::make('Website')->nullable(),
            Text::make('Address')->nullable(),
            //Button::make('Send Contract')->classes(['flex-shrink-0', 'shadow rounded','focus:outline-none', 'ring-primary-200', 'dark:ring-gray-600', 'focus:ring', 'bg-primary-500', 'hover:bg-primary-400', 'active:bg-primary-600', 'text-white', 'dark:text-gray-800', 'inline-flex', 'items-center', 'font-bold', 'px-4', 'h-9', 'text-sm', 'flex-shrink-0'])->onlyOnIndex(),
            
            Heading::make('Please replace {{payopt}} for optional payment link, or {{paylink}} for the real link'),
            Markdown::make('Email Body')->nullable(),
            TextArea::make('Exec Summary')->nullable(),
            TextArea::make('Challenge')->nullable(),
            TextArea::make('Solution')->nullable(),
            
            // 
            ActionButton::make('Sender') // Name in resource table column
            ->icon('<svg width="25px" height="25px" viewBox="0 0 1024 1024" class="icon"  version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M182.52 146.2h585.14v402.28h73.15V73.06H109.38v877.71h402.28v-73.14H182.52z" fill="#0F1F3C" /><path d="M255.66 219.34h438.86v73.14H255.66zM255.66 365.63h365.71v73.14H255.66zM255.66 511.91h219.43v73.14H255.66zM910.72 897.47l-56.19-56.19c17.6-26.2 27.91-57.72 27.91-91.65 0-90.89-73.68-164.57-164.57-164.57S553.3 658.74 553.3 749.63 626.98 914.2 717.87 914.2c30.4 0 58.52-8.82 82.96-23.19L859 949.18l51.72-51.71zM626.45 749.63c0-50.42 41.02-91.43 91.43-91.43s91.43 41.01 91.43 91.43c0 50.41-41.02 91.43-91.43 91.43s-91.43-41.02-91.43-91.43z" fill="#FFFFFF" /></svg>')
            ->action(new Actions\SendContract, $this->resource->id)->hideWhenUpdating(),
            Flexible::make('Products')
            ->addLayout('Product', 'product_single', [
                Text::make('Product Name'),
                TextArea::make('Product Feature'),
                TextArea::make('Product Benefit'),
                Currency::make('Price')->currency('AUD')->locale('EN_au'),
                Flexible::make('Itemised Price')
                ->addLayout('Item', 'item_group', [
                    Text::make('Product Name'),
                    TextArea::make('Product Feature'),
                    TextArea::make('Product Benefit'),
                    Currency::make('Price')->currency('AUD')->locale('EN_au'),
                ]),

            ])->nullable(),
            
            Flexible::make('Stakeholders')
            ->addLayout('Stakeholder', 'stakehold_single', [
                Text::make('Name'),
                Text::make('Position'),
                TextArea::make('Contact Details'),
                TextArea::make('Responsibility')
            ])->nullable(),
            Flexible::make('Schedule')
            ->addLayout('Todo', 'schedule_single', [
                Text::make('Activity'),
                TextArea::make('Description'),
                Text::make('Completion')
            ])->nullable(),
            Flexible::make('Terms')
            ->addLayout('Term', 'term_single', [
                Text::make('Headline'),
                TextArea::make('Description')
            ])->nullable(),
            Currency::make('Price')->currency('AUD')->locale('EN_au')->nullable() 
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
        return [];
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
            new Actions\SendContract
        ];
        
    }
}
