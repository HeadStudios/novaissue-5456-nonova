<?php
use App\Models\Checklist;
use App\Models\User;
use App\Models\Course;
use App\Models\Vlesson;
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Auth;

$course = CourseController::getCourseForLesson($user->id, $vlesson->id);
echo $course->name;
die();
$user_id = $user->id;
$course_id = 2;

$value = 1;
$lesson = Vlesson::whereHas('courses', function($query) use($course_id) {
    $query->where('id', $course_id);
})->whereHas('users', function($query) use ($user_id) {
    $query->where('id', $user_id);
})->orderBy('order_column')->first()->toArray();

echo "<pre>";
var_dump($lesson);
echo "</pre>";

die("We dying the dream");

echo "Course name is: ".$course->name;

$cid = $course->id;
$uid = $user->id;

$lessons = Vlesson::whereHas('courses', function($query) use ($cid) {
    $query->where('id', $cid);
})->whereHas('users', function($query) use($uid) {
    $query->where('id', $uid);
})->get()->toArray();

echo "<pre>";
var_dump($lessons);
echo "</pre>";

die("GOODBYE!");

$course = Course::whereHas('users', function($query) {
    $query->where('id', 91)->whereHas('vlesson', function($query) {
        $query->where('id', 5);
    });
})->first()->toArray();
echo "<pre>";
var_dump($course);
echo "</pre>";

die('boohoo');


echo "VLESSON ID is: ".$vlesson->id." and the user id is: ".$user->id." did you get that?<br />";

$checks = CourseController::getChecklistsByLessonForUser($user->id, $vlesson->id);

echo "<pre>";
foreach($checks as $check) {
    echo $check['name'];
}
var_dump($checks);
echo "</pre>";
die('Go');
?>
Do we have the magic stick? {{ $user->name }}

@foreach($courses as $course)
The name is {{ $course->name }}






$lessons = $user->vlesson()->whereHas('courses', function ($query) use($course) {

    $query->where('course_id', $course->id);


})->get();

foreach($lessons as $lesson) {

    echo "LESSON IS: ";
    echo $lesson->title;
    $lesson_id = $lesson->id;

    
    



        /*$checks = CheckList::where('vlessons_id', $lesson->id)->withPivot('status')->user()->whereHas('users', function($query) use($user) {
            $query->where('id', $user->id);
        })->get();*/

        $checks = CheckList::where('vlessons_id', $lesson->id)->whereHas('users', function($query) use ($user) {
            $query->where('id', $user->id);
        })->get();

        $humor_me = CheckList::where('vlessons_id', $lesson->id)->whereHas('users', function($query) use ($user) {
            $query->where('id', $user->id);
        })->toSql();

        

              


        foreach($checks as $check) {
            //echo "CHECKLIST: ".$check->pivot->status." and status is:<br />";
            //
            echo "CHECKLIST: ".$check->name;
            $checka = DB::table('checklist_user')
           ->where('user_id', $user->id)
           ->where('checklist_id', $check->id)
           ->first();

           

$status = $checka->status;
$approved = $checka->approved;

echo "The status is: ".$status;
        }
        //var_dump($checks);
        //echo "CHECKLIST BEEP BOOP: ".$checklist->name;



}



?>

@endforeach