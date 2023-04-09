@component('mail::message')

# You Have New Lessons Assigned

@component('mail::button', ['url' => $lesson->getVlessonUrl().'?magic='.$user->magic])
Lesson: {{ $lesson->title }}
@endcomponent

@endcomponent