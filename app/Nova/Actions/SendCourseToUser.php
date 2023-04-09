<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\Course;
use App\Models\User;
use App\Models\Checklist;
use Illuminate\Support\Facades\Mail;
use App\Hydraulics\Course\CourseMailer;


class SendCourseToUser extends Action
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

        foreach($models as $model) {
            $user = User::find($model->id);
            $course = Course::find($fields->course);
            $user->emailLessonsAndChecklistsFor($course);
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
            Select::make('Course')
                ->options(Course::all()->pluck('name', 'id'))
                ->displayUsingLabels()
                ->sortable()
        ];
    }
}
