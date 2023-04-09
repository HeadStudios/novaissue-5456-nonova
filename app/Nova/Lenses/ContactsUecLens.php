<?php

namespace App\Nova\Lenses;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Lenses\Lens;
use Carbon\Carbon;


class ContactsUecLens extends Lens
{
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [];

    /**
     * Get the query builder / paginator for the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\LensRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return mixed
     */
    public static function query(LensRequest $request, $query)
    {
        return $query->whereHas('touchpoints', function ($query) {
            $query->where('uec', 1);
        });
        
    }

    /**
     * Get the fields available to the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make('Name')->nullable(true),
            Text::make('Email')->nullable(true),
            Text::make('BDM', function () {
                return $this->user ? 'Yes' : '';
            })->displayUsing(function ($value) {
                if($value == 'Yes') {
                return $value ? '<svg width="25px" height="25px" version="1.1" id="Icons" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                viewBox="0 0 32 32" xml:space="preserve">
           <style type="text/css">
               .st0{fill:none;stroke:#000000;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}
               .st1{fill:none;stroke:#000000;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;}
               .st2{fill:none;stroke:#000000;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-dasharray:5.2066,0;}
           </style>
           <line class="st0" x1="3" y1="11" x2="29" y2="11"/>
           <line class="st0" x1="7" y1="8" x2="7" y2="8"/>
           <line class="st0" x1="10" y1="8" x2="10" y2="8"/>
           <line class="st0" x1="13" y1="8" x2="13" y2="8"/>
           <rect x="3" y="5" class="st0" width="26" height="22"/>
           <rect x="6" y="14" class="st0" width="10" height="10"/>
           <rect x="19" y="21" class="st0" width="7" height="3"/>
           <line class="st0" x1="20" y1="15" x2="26" y2="15"/>
           <line class="st0" x1="23" y1="18" x2="26" y2="18"/>
           <polyline class="st0" points="6,22 12,19 16,22 "/>
           <line class="st0" x1="9" y1="17" x2="9" y2="17"/>
           </svg>' : ''; // Replace '...' with your actual SVG icon code.
                }
            })
            ->asHtml(),
            Text::make('Audit', function () {
                return $this->audit ? 'Yes' : '';
            })
            ->displayUsing(function ($value) {
                return $value ? '<svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13 18.75H6C5.27065 18.75 4.57118 18.4603 4.05546 17.9445C3.53973 17.4288 3.25 16.7293 3.25 16V8C3.25 7.27065 3.53973 6.57118 4.05546 6.05546C4.57118 5.53973 5.27065 5.25 6 5.25H13C13.7293 5.25 14.4288 5.53973 14.9445 6.05546C15.4603 6.57118 15.75 7.27065 15.75 8V16C15.75 16.7293 15.4603 17.4288 14.9445 17.9445C14.4288 18.4603 13.7293 18.75 13 18.75ZM6 6.75C5.66848 6.75 5.35054 6.8817 5.11612 7.11612C4.8817 7.35054 4.75 7.66848 4.75 8V16C4.75 16.3315 4.8817 16.6495 5.11612 16.8839C5.35054 17.1183 5.66848 17.25 6 17.25H13C13.3315 17.25 13.6495 17.1183 13.8839 16.8839C14.1183 16.6495 14.25 16.3315 14.25 16V8C14.25 7.66848 14.1183 7.35054 13.8839 7.11612C13.6495 6.8817 13.3315 6.75 13 6.75H6Z" fill="#000000"/>
                <path d="M20 16.75C19.8626 16.7479 19.7282 16.71 19.61 16.64L14.61 13.64C14.5002 13.5732 14.4094 13.4792 14.3463 13.3671C14.2833 13.255 14.2501 13.1286 14.25 13V11C14.2501 10.8714 14.2833 10.745 14.3463 10.633C14.4094 10.5209 14.5002 10.4269 14.61 10.36L19.61 7.36002C19.7248 7.2913 19.8562 7.255 19.99 7.255C20.1238 7.255 20.2552 7.2913 20.37 7.36002C20.485 7.42526 20.5807 7.51973 20.6475 7.63388C20.7142 7.74804 20.7496 7.8778 20.75 8.01003V16.01C20.7496 16.1423 20.7142 16.272 20.6475 16.3862C20.5807 16.5003 20.485 16.5948 20.37 16.66C20.2572 16.7232 20.1292 16.7543 20 16.75ZM15.75 12.58L19.25 14.68V9.32002L15.75 11.42V12.58Z" fill="#000000"/>
                </svg>' : ''; // Replace '...' with your actual SVG icon code.
            })
            ->asHtml(),

            Text::make('Content', function () {
                if ($this->user && count($this->user->campaigns) >= 3) {
                    $validCampaigns = 0;
                    foreach ($this->user->campaigns as $campaign) {
                        if (!empty($campaign->video_thumbnail) && substr($campaign->tiktok_url, -3) === 'mp4') {
                            $validCampaigns++;
                        }
                    }
                    return $validCampaigns >= 3 ? 'Yes' : '';
                }
                return '';
            })->displayUsing(function ($value) {
                if($value == 'Yes') {
                return $value ? '<svg width="25px" height="25px" viewBox="0 -8 72 72" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg"><defs><style>.cls-1{fill:#010002;}</style></defs><title>presenter</title><path d="M55.79,29.68H16.21a2,2,0,0,0-2,2.21l.53,6.32A4.09,4.09,0,0,0,18.78,42h.65l3.74,14H48.76l3.75-14h.71a4.09,4.09,0,0,0,4.08-3.75l.53-6.32A2,2,0,0,0,55.79,29.68Z"/><path class="cls-1" d="M51.15,27.37a15.33,15.33,0,0,0-8.07-11.61C41.26,17.57,38.76,27.49,36,27.49s-5.26-9.92-7.08-11.73a15.32,15.32,0,0,0-8.07,11.61,1,1,0,0,0,.25.82,1.28,1.28,0,0,0,.95.42H50a1.28,1.28,0,0,0,.95-.42A1,1,0,0,0,51.15,27.37Zm-4.43-3.85h-4v-.85h4Z"/><path class="cls-1" d="M29.71,14.66l.51.49a8.63,8.63,0,0,0,11.56,0l.51-.49c.16-.17.32-.35.46-.53a8.6,8.6,0,0,0,1.93-5.45,8.68,8.68,0,0,0-17.36,0,8.6,8.6,0,0,0,1.93,5.45C29.39,14.31,29.55,14.49,29.71,14.66Z"/><path class="cls-1" d="M36.91,19.4a.24.24,0,0,1-.24.24H35.33a.24.24,0,0,1-.24-.24V18.06a.23.23,0,0,1,.24-.23h1.34a.23.23,0,0,1,.24.23Z"/><polyline class="cls-1" points="35.01 20.19 36.93 20.19 37.84 27.8 34.1 27.8"/></svg>' : ''; // Replace '...' with your actual SVG icon code.
                }
            })
            ->asHtml(),

            Text::make('Next Contact Date', function () {
                $futureTouchpoints = $this->touchpoints->filter(function ($touchpoint) {
                    return $touchpoint->date->isFuture();
                });
            
                if ($futureTouchpoints->isNotEmpty()) {
                    $nextTouchpoint = $futureTouchpoints->sortBy('date')->first();
                    return $nextTouchpoint->date->format('Y-m-d');
                }
                return 'Call!';
            }),
        ];
    }

    /**
     * Get the cards available on the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available on the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return parent::actions($request);
    }

    /**
     * Get the URI key for the lens.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'contacts-uec-lens';
    }
}
