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
use Illuminate\Support\Facades\Event;
use App\Events\CourseAttachedToUser;

class AttachCourseToUser extends Action
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
            
            $course = Course::with('vlessons')->with('vlessons.checklists')->find($fields->course);
            $user = User::find($model->id);

            if (!$user->courses()->where('courses.id', $course->id)->exists()) {
                $user->courses()->attach($course->id);
            }
            $user->getMagicaAttribute();

            if (!$user->vlessons()->whereIn('vlessons.id', $course->vlessons->pluck('id'))->exists()) {
                $user->vlessons()->attach($course->vlessons->pluck('id'));
                $user->attachVlessons($course->vlessons->pluck('id'));
            }

            foreach($course->vlessons as $vlesson) {
                if (!$user->checklists()->whereIn('checklists.id', $vlesson->checklists->pluck('id'))->exists()) {
                    foreach($vlesson->checklists as $checklist) {
                        $user->checklists()->attach($checklist->id);
                    }
                }
            }
            Event::dispatch(new CourseAttachedToUser($user, $course));

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
