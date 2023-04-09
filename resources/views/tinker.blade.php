This is the tinker times

@foreach($user->courses as $course)
The course name is: {{ $course->name }} <br />
@foreach($course->vlessonForUser($user) as $vlesson)
The Vlesson is: {{$vlesson->title}} <br />


@endforeach
@endforeach