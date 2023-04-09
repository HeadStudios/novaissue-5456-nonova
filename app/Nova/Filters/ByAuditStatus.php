<?php

namespace App\Nova\Filters;

use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\VideoAudit;

class ByAuditStatus extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(NovaRequest $request, $query, $value)
    {
        /*return $query->whereHas('courses', function ($query) use ($value) {
            $query->whereIn('courses.id', (array) $value);
        });*/
        return $query->whereIn('status', (array) $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function options(NovaRequest $request)
    {
        //return [];
        //$status = VideoAudit::all()->pluck('status')->toArray(); //->flip()->toArray();
        $status = VideoAudit::distinct()->pluck('status')->toArray();
        
        
        return $status;
    }
}
