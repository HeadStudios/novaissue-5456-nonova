<?php

namespace App\Nova\Dashboards;

use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;
use Coroowicaksono\ChartJsIntegration\StackedChart;
use InteractionDesignFoundation\HtmlCard\HtmlCard;


class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {

        if (!session()->has('google_access_token')) {
            $card = "<a href='/login/google/'>Login to verify</a>";
        } else {
            $card = "You are Google Verified!";
        }
        return [
            (new StackedChart())
    ->title('Effective Convos')
    ->model('\App\Models\Touchpoint') // Use Your Model Here
    ->col_xaxis('date') // Add Your Custom X-Axis here
    ->series(array([
        'label' => 'UECs',
        'filter' => [
            'key' => 'uec', // State Column for Count Calculation Here
            'value' => '1'
        ],
    ]))
    ->options([
        'showTotal' => false // Hide Show Total in Your Chart
    ])
    ->width('1/2'),

    (new StackedChart())
    ->title('Total Volume')
    ->model('\App\Models\Touchpoint') // Use Your Model Here
    ->col_xaxis('date') // Add Your Custom X-Axis here
    ->series(array([
        'label' => 'Voicemail',
        'filter' => [
            'key' => 'call_result', // State Column for Count Calculation Here
            'value' => 'Voicemail'
        ],
    ],[
        'label' => 'Not Interested',
        'filter' => [
            'key' => 'call_result', // State Column for Count Calculation Here
            'value' => 'Not Interested'
        ],
    ],[
        'label' => 'Call Me Back',
        'filter' => [
            'key' => 'call_result', // State Column for Count Calculation Here
            'value' => 'Call Me Back'
        ],
    ]))
    ->options([
        'btnFilter' => true,
        'btnFilterDefault' => '7',
        'btnFilterList' => [
            'YTD'   => 'Year to Date',
            'QTD'   => 'Quarter to Date',
            'MTD'   => 'Month to Date',
            '30'   => '30 Days', // numeric key will be set to days
            '7'   => '7 Days', // numeric key will be set to days
        ],
        'showTotal' => false, // Hide Show Total in Your Chart
        'latestData' => 6, // Show last 6 weeks data (optional)
        'uom' => 'day' // available in 'day', 'week', 'month', 'hour'
    ])
    ->width('1/2'),

    (new StackedChart())
    ->title('Money Slam')
    ->model('\App\Models\Opps') // Use Your Model Here
    ->col_xaxis('date') // Add Your Custom X-Axis here
    ->options([
        'uom' => 'week',
        'latestData' => 12,
        'showTotal' => false, // Hide Show Total in Your Chart
        'sum' => 'price'
    ])
    ->width('1/2'),

    (new HtmlCard())->width('1/2')->html($card),

    
        ];
    }
}
