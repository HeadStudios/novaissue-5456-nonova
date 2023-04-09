<?php

namespace App\Listeners;

use App\Events\CourseAttachedToUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\CourseMail;

class EmailUserAboutCourseAttach
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\CourseAttachedToUser  $event
     * @return void
     */
    public function handle(CourseAttachedToUser $event)
    {
        $user = $event->user;
        $course = $event->course;

        
        $checklists = $user->getChecklistsIn($course);
        $lessons = $course->getLessonsBy($user);
        Mail::to('enquiries@headstudios.com.au')->send(new CourseMail($user,$course, $lessons, $checklists));
        
    }
}
