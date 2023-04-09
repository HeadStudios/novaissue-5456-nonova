<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Checklist;
use App\Models\User;
use App\Models\Vlesson;
use Barryvdh\DomPDF\Facade\Pdf;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;
use Illuminate\Database\Eloquent\Builder;

class Course extends Model
{
    use HasFactory;

    public $table = 'courses';
    public static $title = 'name';

    public function checklists() {
        return $this->hasMany(Checklist::class);
    }

    /*public function vlesson() {
        return $this->hasMany(Vlesson::class);
    }*/

    public function vlessons() {
        return $this->belongsToMany(Vlesson::class);
    }

    public function getCourseURLFor(User $user) {
        $lesson = Vlesson::whereHas('courses', function($query) {
            $query->where('id', $this->id);
        })->whereHas('users', function($query) use($user)  {
            $query->where('id', $user->id);
        })->orderBy('order_column')->first();
        if($lesson) { return $lesson->getVlessonUrl(); }
        else { return '#'; }
        
    }

    public function getLessonsBy(User $user) {
        $course_id = $this->id;
        $user_id = $user->id;

        
        

        //$query = Vlesson::join('vlesson_user', 'vlesson_user.vlesson_id', '=', 'vlessons.id')->join('course_vlesson', 'course_vlesson.vlesson_id', '=', 'vlessons.id')->where('vlesson_user.user_id', '91')->where('course_vlesson.course_id', $course_id);
        //

       
        //return Vlesson::join('vlesson_user', 'vlesson_user.vlessons_id', '=', 'vlessons.id')->join('course_vlesson', 'course_vlesson.vlesson_id', '=', 'vlessons.id')->where('vlesson_user.user_id', $user_id)->where('course_vlesson.course_id', $course_id)->where('vlesson_user.user_id', $user_id)->get()->pluck('id');
        return Vlesson::join('vlesson_user', 'vlesson_user.vlessons_id', '=', 'vlessons.id')->join('course_vlesson', 'course_vlesson.vlesson_id', '=', 'vlessons.id')->where('vlesson_user.user_id', $user_id)->where('course_vlesson.course_id', $course_id)->where('vlesson_user.user_id', $user_id)->get();
    }

    public function getLessonsIDsBy(User $user) {
        $course_id = $this->id;
        $user_id = $user->id;

        
        

        //$query = Vlesson::join('vlesson_user', 'vlesson_user.vlesson_id', '=', 'vlessons.id')->join('course_vlesson', 'course_vlesson.vlesson_id', '=', 'vlessons.id')->where('vlesson_user.user_id', '91')->where('course_vlesson.course_id', $course_id);
        //

       
        return Vlesson::join('vlesson_user', 'vlesson_user.vlessons_id', '=', 'vlessons.id')->join('course_vlesson', 'course_vlesson.vlesson_id', '=', 'vlessons.id')->where('vlesson_user.user_id', $user_id)->where('course_vlesson.course_id', $course_id)->where('vlesson_user.user_id', $user_id)->get()->pluck('id');
        //return Vlesson::join('vlesson_user', 'vlesson_user.vlessons_id', '=', 'vlessons.id')->join('course_vlesson', 'course_vlesson.vlesson_id', '=', 'vlessons.id')->where('vlesson_user.user_id', $user_id)->where('course_vlesson.course_id', $course_id)->where('vlesson_user.user_id', $user_id)->get();
    }

    public function users() {
        return $this->belongsToMany(User::class, 'course_user');
    }

    public function isCompletedBy(User $user) {

        $user_id = $user->id;
        $course_id = $this->id;

        $plucks = $this->getLessonsIDsBy($user);

        
        
        

        $lessons = Vlesson::whereHas('users', function($query) use($user_id)  {
            $query->where('id', $user_id);
        })->with(['users' => function ($query) use($user_id) {
            $query->where('id', $user_id)->withPivot('watched');
        }])->whereIn('id', $plucks)->get()->pluck('user.0.pivot.watched')->every(function ($value) {
            return $value === 1;
        });
    
        if (!$lessons) {
            return false;
        } 

        $checklists = Checklist::whereHas('users', function($query) use($user_id) {
            $query->where('id', $user_id);
        })->whereIn('vlessons_id', $plucks)->with(['users' => function ($query) {
            $query->withPivot('status');
        }])->get()->pluck('user.0.pivot.status')->every(function ($value) {
            return $value === 1;
        });
    
        if (!$checklists) {
            return false;
        } 

        return true;

    }

    public function printAllLessonsInCourseFor(User $user) {
  
        $lessons = $user->getLessonsforUserFromCourse($this->id, true);
        $pdfs = [];
        
        $merger = PDFMerger::init();
        foreach($lessons as $lesson) {
            $name = $lesson->title;
            $checklists = $lesson->checklists;
            $parsedown = new \Parsedown();
            $content = $parsedown->text($lesson->lesson_outline);
            $pdf = Pdf::loadView('lms.pdf.boomshaka', compact('name', 'content', 'checklists'));
            $pdfs[] = $pdf;
        }
        foreach ($pdfs as $pdf) {
            $merger->addString($pdf->output());
        }
        //$pdf = Pdf::loadView('lms.pdf.boomshaka');
        $merger->merge();
        return response()->make($merger->stream(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="startthefire.pdf"'
          ]);
  
    
        //return $html;
        


}

}
