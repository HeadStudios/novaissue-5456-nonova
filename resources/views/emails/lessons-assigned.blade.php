@php
use App\Hydraulics\Course\CourseMailer;
@endphp
@component('mail::message')
# You Have Lessons Assigned in the {{ $course->name }} Course

Please check the lessons assigned to you:

@foreach($lessons as $lesson)
- <a href="{{ CourseMailer::getMagicVLessonLinkFor($user, $lesson) }}">{{ $lesson->title }}</a>
@endforeach

# Tasks Assigned

Please check the Checklists assigned to you:

@foreach($checklists as $checklist)
- {{ $checklist->name }}
@endforeach

@endcomponent