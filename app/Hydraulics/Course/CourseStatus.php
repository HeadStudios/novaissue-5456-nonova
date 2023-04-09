<?php

namespace App\Hydraulics\Course;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Models\Opps;
use App\Models\User;
use App\Models\Campaign;
use App\Jobs\SendAPacket;
use App\Models\Checklist;
use App\Models\Vlesson;
use App\Models\Course;
use \TANIOS\Airtable\Airtable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class CourseStatus {

    protected $course;
    protected $user;
    protected $css_id;

    public function __construct() {
    }

    public function generateJSChartCode(User $user) {
        $code = '
        const '.$this->getCSSID($user).' = document.getElementById("'.$this->getCSSID($user).'").getContext(\'2d\');
        new Chart("'.$this->getCSSID($user).'", {
            type: "doughnut",
            data: {
            datasets: [{
                data: '.json_encode($this->getTotalStatusFor($user->id)).',
                backgroundColor: ["#00c853", "#e0e0e0"],
                labels: "Course Completed"
            }]
        },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                aspectRatio: 3/2,
            cutoutPercentage: 75,
            legend: {
                display: true,
                display: "bottom",
                labels: {
                    boxWidth: 20,
                    fontColor: \'black\'
                }
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var dataset = data.datasets[tooltipItem.datasetIndex];
                        var index = tooltipItem.index;
                        if (index === 0) {
                            return \'Checklists Completed|Videos Watched: \' + dataset.data[index] + \'%\';
                        } else {
                            return \'Checklists Not Completed|Videos Not Watched: \' + dataset.data[index] + \'%\';
                        }
                    }
                }
            }
        }
          });';
        return $code;
    }

    public function getTotalStatusFor($id) {

        $checklist_count = DB::table('checklist_user')
                         ->where('user_id', $id)
                         ->count();

        $vlesson_count = DB::table('vlesson_user')
                            ->where('user_id', $id)
                            ->count();

        $completed_count = DB::table('checklist_user')
                             ->where('user_id', $id)
                             ->where('status', 1)
                             ->count();
    
        $watched_count = DB::table('vlesson_user')
                            ->where('user_id', $id)
                            ->where('watched', 1)
                            ->count();

        $total = $checklist_count + $vlesson_count;
        $percentage = $completed_count + $watched_count;

        if($total == 0) {
            return [0, 100];
        }
        $percentage = round($percentage / $total * 100);
        $remaining = 100 - $percentage;
    
        return [$percentage, $remaining];
    }
    
    protected function getCSSID(User $user) {
        return 'chrt_'.$user->id;
    }
    
    public function getCourseStatusFor(User $user, Course $course) {
        $course_id = $course->id;
        $user_id = $user->id;
        $lessons = $this->getLessonsFor($user, $course);
        
        $pluck = $lessons->pluck('id');
        

        $checklists = $user->getCheckListsIn($course);
        $total = $lessons->count() + $checklists->count();
        
        $watched = $this->getWatchedLessonsFor($user, $course);
        $ticked = $this->getCompletedLessonsFor($user, $pluck);
        
        $completed = $watched + $ticked;
        
        $percent = round($completed / $total * 100);
        $needed = 100 - $percent;
        return array($percent, $needed);
    }

    protected function getLessonsFor(User $user, Course $course) {
        $course_id = $course->id;
        $user_id = $user->id;
        $lessons = DB::table('vlessons')
        ->join('vlesson_user', 'vlesson_user.vlessons_id', '=', 'vlessons.id')
        ->join('course_vlesson', 'course_vlesson.vlesson_id', '=', 'vlessons.id')
        ->where('vlesson_user.user_id', $user_id)
        ->where('course_vlesson.course_id', $course_id)
        ->get();
        return $lessons;
    }

    protected function getCompletedLessonsFor(User $user, $plucks) {
        $user_id = $user->id;
        $checklistCount = DB::table('checklists')
    ->join('checklist_user', 'checklist_user.checklist_id', '=', 'checklists.id')
    ->whereIn('checklists.vlessons_id', $plucks)
    ->where('checklist_user.user_id', $user->id)
    ->where('checklist_user.status', 1)
    ->count();
        return $checklistCount;
    }

    protected function getWatchedLessonsFor(User $user, Course $course) {
        $course_id = $course->id;
        $user_id = $user->id;
        $lessons = DB::table('vlessons')
        ->join('vlesson_user', 'vlesson_user.vlessons_id', '=', 'vlessons.id')
        ->join('course_vlesson', 'course_vlesson.vlesson_id', '=', 'vlessons.id')
        ->where('vlesson_user.user_id', $user_id)
        ->where('course_vlesson.course_id', $course_id)
        ->where('vlesson_user.watched', 1)
        ->get()->count();
        return $lessons;
    }

    protected function getAllWatchedLessonsFor(User $user, Course $course) {
        $course_id = $course->id;
        $user_id = $user->id;
        $lessons = DB::table('vlessons')
        ->join('vlesson_user', 'vlesson_user.vlessons_id', '=', 'vlessons.id')
        ->join('course_vlesson', 'course_vlesson.vlesson_id', '=', 'vlessons.id')
        ->where('vlesson_user.user_id', $user_id)
        ->where('vlesson_user.watched', 1)
        ->get()->count();
        return $lessons;
    }

    

    //->where('vlesson_user.watched', $user_id)

}
