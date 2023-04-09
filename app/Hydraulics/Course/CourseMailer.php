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


class CourseMailer {

    public static function getMagicVLessonLinkFor(User $user, Vlesson $vlesson) {
        if($user->magic != null) {
            $magic = $user->magic;
            $perma = $vlesson->permalink;
            //return $perma;
            return route('ovlesson', ['perma' => $perma])."?magic=".$magic;

        }
        //$url = route('course.lesson', ['user' => $user->id, 'lesson' => $lesson->id]);
        return "No magic";
    }

    

}
