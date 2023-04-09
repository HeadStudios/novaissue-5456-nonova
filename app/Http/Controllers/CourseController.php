<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Models\Vlesson;
use App\Models\Checklist;
use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use App\Hydraulics\Campaigner;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;




class CourseController extends Controller
{

    public $user_id;
    public $less_id;
    public $style_h = '';
    
public function __construct()
{



}

function updateWatched($userId, $vlessonId, $watched)
{
    DB::table('vlesson_user')
        ->where('user_id', $userId)
        ->where('vlessons_id', $vlessonId)
        ->update(['watched' => $watched]);

    $user = User::find($userId);
    $user->isFinished();
}

public function checkit($user_id, $id, $set) {

  DB::table('checklist_user')
->where('user_id', $user_id)
->where('checklist_id', $id)
->update(['status' => $set]);

  //$check = Checklist::where('id', $id)->first();
  //$check->status = $set;
  //$check->save();


  
}

public function appit($user_id, $id, $set) {

  DB::table('checklist_user')
->where('user_id', $user_id)
->where('checklist_id', $id)
->update(['approved' => $set]);

  //$check = Checklist::where('id', $id)->first();
  //$check->status = $set;
  //$check->save();


  
}

protected function getNextVlesson($vlesson, $lessons)
{
    // Find the index of the $vlesson model in the $lessons list
    $index = $lessons->search(function($item) use ($vlesson) {
        return $item->id === $vlesson->id;
    });

    // If the $vlesson model is not found in the list, return '/dashboard'
    if ($index === false) {
        return '/lms/dashboard';
    }

    // If the $vlesson model is the last model in the list, return '/dashboard'
    if ($index === $lessons->count() - 1) {
        return '/lms/dashboard';
    }

    // Otherwise, return the URL of the next model in the list
    
    return $lessons[$index + 1]->getVlessonURL();
}


  

  public function getCourseUrl($lesson_id) {

    $lesson = Vlesson::find($lesson_id);
    return '/ovlesson/'.$lesson->permalink;

  }

  public function assignment(Request $request) {
    $user_id = $request->input('user_id');
    $vlesson_id = $request->input('vlesson_id');

    // Get the assignment text from the request
    $assignment = $request->input('assignment');

    dump("User id is: ".$user_id." and the vlesson id is: ".$vlesson_id." and the text returned is: ".$assignment);

    DB::table('vlesson_user')
    ->where('user_id', $user_id)
    ->where('vlessons_id', $vlesson_id)
    ->update(['assignment' => $assignment]);

    
    
    
    
  }

  public static function courseStatus($vlesson_id) {

    $status = [];
    $approved = [];
    $checklist = Checklist::where('user_id', Auth::id())->where('vlessons_id', $vlesson_id)->get();
    foreach($checklist as $check) {
        $status[] = $check->status;
        $approved[] = $check->approved;
    }


        

    if(!in_array(0, $approved)) {
        return "Approved";    
    } elseif(!in_array(0, $status)) {
        return "Completed";
    } else {
        return "Todo";
    }

  }

    public function vlesson($perma, Request $request) {

      //return view('backend.login');
      /*
      if(!$this->persist($request)) {
        return view('lms.login');
      } 
      
      if (Auth::check()) {
        $userId = Auth::id();
        
        Auth::loginUsingId(1, true);
        
    } else {
        
    } */

    


    

        $vlesson = Vlesson::where('permalink', $perma)->first();

        //$lessons = Vlesson::where('check_group_id', $vlesson->check_group_id)->get();
        //$course = Course::where('id', $vlesson->check_group_id)->first();
        
        

        //$checklist = Checklist::where('user_id', $user_id)->where('vlessons_id', $less_id)->get();

        

    //return view('course-single', [ 'checklist' => $checklist, 'next' => $next->id, 'user_id' => $user_id /*'course_lessons' => $lessons  /*'course' => $course */ ]);
    //return view('lms.public-lesson', ['vlesson' => $vlesson]);
    return view('lms.public-lesson', ['vlesson' => $vlesson]);

    }

    

    public function printd($user_id) {

        $this->user_id = $user_id;

        $html = self::tableWalk();
        $pdf = Pdf::loadHTML($html);
        //return $html;
        return response()->make($pdf->stream(), 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="startthefire.pdf"'
    ]);


        //return view('course-single', ['vlesson' => $vlesson, 'checklist' => $checklist, 'next' => $next->id]);

    }

    

    public function printc($uid, $lid) {

      $this->user_id = $uid;
      $this->less_id = $lid;

      $vlesson = Vlesson::where('id', $lid)->first();
      $user = User::find($uid);
      $name = $vlesson->title;
      $checklists = $vlesson->checklists;
      $parsedown = new \Parsedown();
      $content = $parsedown->text($vlesson->lesson_outline);

      $pdf = Pdf::loadView('lms.pdf.boomshaka', compact('name', 'content', 'checklists'));
      return $pdf->stream();

      return response()->make($pdf->stream(), 200, [
      'Content-Type' => 'application/pdf',
      'Content-Disposition' => 'inline; filename="startthefire.pdf"'
  ]);


      //return view('course-single', ['vlesson' => $vlesson, 'checklist' => $checklist, 'next' => $next->id]);

  }

    public function tableWalk() {
        return $this->top_talk.self::printDTaskRows(Auth::id()).'
        </tbody>
        </table>';
        //return $this->top_talk.self::tableSexy();
        
    }

    public function cTableWalk() {
      return $this->top_talk.self::printCTaskRows($this->user_id, $this->less_id).'
      </tbody>
      </table>';
      
  }

  public function tableSexy($checklist) 
  {
    
    $html = '<table class="tg" style="width:100%;"><thead>
    <tr>
      <th class="tg-dvid" style="width:20%;">Assignee</th>
      <th class="tg-dvid" style="width:20%;">Task Name</th>
      <th class="tg-dvid"><span style="font-weight:700;font-style:normal">Task Description</span></th>
      <th class="tg-dvid" style="width:20%;"><span style="font-weight:700;font-style:normal">Status</span></th>
    </tr>
  </thead>
  <tbody>';

  
  

  $name = User::where('id', Auth::id())->first();

  foreach($checklist as $row) {


    $status = ($row->status == 1) ? 'tg-yofg' : 'tg-0lax';
          $html .= '<tr>
          <td class="tg-0pky">'.$name->name.'</td>
          <td class="tg-0pky">'.$row->name.'</td>
          <td class="tg-0lax">'.$row->description.'</td>
          <td class="'.$status.'"></td>
        </tr>';


  }

  

  $html .= '</tbody>
  </table>';

  return $html;

  }

    public function printDTaskRows($user_id) {

      $checker = Course::with(["checklist" => function($q) use($user_id){
        $q->where('checklist.user_id', '=', $user_id);
        }])->get();
        $name = User::where('id', $this->user_id)->first();
        //$rows = Checklist::where('user_id', )
        $html = '';
        foreach($checker as $group) {
          $html .= '<h3>'.$group->name.'</h3>';

          $html .= self::tableSexy($group->checklist);
          
          //$html .= $this->thead;
          /*foreach($group->checklist as $row) {
            
            $status = ($row->status == 1) ? 'tg-yofg' : 'tg-0lax';
            $html .= '<tr style="border-bottom: 1pt solid black;">
            <td class="tg-0pky">'.$name->name.'</td>
            <td class="tg-0pky">'.$row->name.'</td>
            <td class="tg-0lax">'.$row->description.'</td>
            <td class="'.$status.'"></td>
          </tr>';
          }*/
          $html .= '</tbody>';
        }
        
        return $html;

    }

    public function printCTaskRows($user_id, $lesson_id) {

      //$rows = Checklist::where('user_id', )
      $html = '';
      $rows = Checklist::where('user_id', $this->user_id)->where('vlessons_id', $lesson_id)->get();
      $name = User::where('id', $this->user_id)->first();
      foreach($rows as $row) {
          $status = ($row->status == 1) ? 'tg-yofg' : 'tg-0lax';
          $html .= '<tr>
          <td class="tg-0pky">'.$name->name.'</td>
          <td class="tg-0pky">'.$row->name.'</td>
          <td class="tg-0lax">'.$row->description.'</td>
          <td class="'.$status.'"></td>
        </tr>';
        //tg-yofg
        
      }
      return $html;

  }

  public static function getChecklistsByLessonForUser($user_id, $vlesson_id)
{
    // Generate a unique cache key based on the user and lesson IDs
    $cacheKey = "checklists_by_lesson_{$user_id}_{$vlesson_id}";

    // Check the cache for the checklist data
    /*$checks = Cache::get($cacheKey);
    if (!$checks) {
        // If the checklist data is not in the cache, retrieve it from the database
        $checks = User::find($user_id)->checklists()->where('vlessons_id', $vlesson_id)->get();
        
        /*$checks = CheckList::where('vlessons_id', $vlesson_id)->whereHas('users', function ($query) use ($user_id) {
            $query->where('id', $user_id);
        })->get();*/

        // Store the checklist data in the cache for future use
       // Cache::put($cacheKey, $checks, now()->addMinutes(60));
    //} */
    $checks = User::find($user_id)->checklists()->where('vlessons_id', $vlesson_id)->get();
    return $checks;
}




  public function getCourseForLesson($user_id, $lesson_id)
  {
      // Generate a unique cache key based on the user and lesson IDs
      $cacheKey = "course_for_lesson_{$user_id}_{$lesson_id}";
  
      // Check the cache for the course data
      $course = Cache::get($cacheKey);
      if (!$course) {
          // If the course data is not in the cache, retrieve it from the database
          $course = Course::whereHas('vlessons', function ($query) use ($lesson_id, $user_id) {
              $query->where('id', $lesson_id);
          })->with(["vlessons" => function ($q) use ($user_id) {
              $q->whereHas('users', function ($query) use ($user_id) {
                  $query->where('id', $user_id);
              });
          }])->first();
  
          // Store the course data in the cache for future use
          Cache::put($cacheKey, $course, now()->addMinutes(60));
      }
  
      return $course;
  }

  public function getNextLessonURL($course_id, $user_id, $order) {

    

    $lesson = Vlesson::whereHas('courses', function($query) use($course_id) {
      $query->where('id', $course_id);
  })->whereHas('users', function($query) use ($user_id) {
      $query->where('id', $user_id);
  })->where('order_column', '>', $order)->orderBy('order_column')->first();

  

  if($lesson) {
    return self::getCourseUrl($lesson->id);
  } else { return "/dashboard"; }
}

public function course($perma) {

  $course = Course::where('permalink', $perma)->first();

  if (Auth::check()) {
    $user_id = Auth::id();
} else {
    Auth::loginUsingId(94);
    $user_id = Auth::id();
}

  $lessons = Vlesson::whereHas('courses', function($query) use($course) {
    $query->where('id', $course->id);
})->whereHas('users', function($query) use ($user_id) {
    $query->where('id', $user_id);
})->orderBy('order_column')->get();

  return view('lms.course', compact('course', 'lessons'));

}

  

  public function oldvlesson($perma, Request $request) {
    

    if(!$this->persist($request)) {
      return view('lms.login');
    } 

    $vlesson = Vlesson::where('permalink', $perma)->first();

    $checklist = self::getChecklistsByLessonForUser(Auth::id(), $vlesson->id);

    $user = User::find(Auth::id());

    return view('course-single', ['vlesson' => $vlesson, 'user' => $user, 'checklist' => $checklist ]);

   



    


    //$bigTime = self::getChecklistByCourseForUser($user_id);

    

    

    $course = self::getCourseForLesson(Auth::id(), $vlesson->id);

    //$lessons = Vlesson::where('check_group_id', $vlesson->check_group_id)->get();
    //$lessons = $user->getLessonsforUserFromCourse($course->id);//self::getLessonsforUserFromCourse($course->id, Auth::id());
    $lessons = $course->vlessons()->orderBy('order_column')->get();
    //$course = Course::where('id', $vlesson->check_group_id)->first();
    $next_url = self::getNextVlesson($vlesson, $lessons);

    $less_id = $vlesson->id;
    //$next = Vlesson::where('id', '!=', $less_id)->first();
    
    

    //$checklist = Checklist::where('user_id', $user_id)->where('vlessons_id', $less_id)->get();
    
    
    return view('lms.single-vlesson', ['user'=> $user, 'user_id' => $user->id, 'vlesson' => $vlesson, 'checklist' => $checklist, 'course_lessons' => $lessons, 'course' => $course, 'next' => $next_url]);

}



public static function getChecklistByCourseForUser($user_id) {

  

/*$courses = DB::table('courses')
  ->join('course_user', 'course_user.course_id', '=', 'courses.id')
  ->where('course_user.user_id', 91)
  ->pluck('courses.id')
  ->toArray(); */

$courses = DB::table('courses')
->join('course_user', 'course_user.course_id', '=', 'courses.id')
->where('course_user.user_id', $user_id)
->get();

$bigTimeArray = [];

foreach($courses as $course) {
  

  $vlessons = DB::table('vlessons')
  ->join('course_vlesson', 'course_vlesson.vlesson_id', '=', 'vlessons.id')
  ->where('course_vlesson.course_id', $course->id)->pluck('vlessons.id')->toArray();

  $checklist = DB::table('checklists')
  ->whereIn('vlessons_id', $vlessons)->pluck('checklists.id')->toArray();

  $uchecks = DB::table('checklists')
  ->join('checklist_user', 'checklist_user.checklist_id', '=', 'checklists.id')
  ->whereIn('checklists.id', $checklist)
  ->where('checklist_user.user_id', $user_id)
  ->get();

  if(!$uchecks->isEmpty()) {
    //echo "The course name is: ".$course->name."<br />";

    $innerA = ['course_name' => $course->name, 'course_id' => $course->id, 'checklists' => $uchecks->toArray()];
    array_push($bigTimeArray, $innerA);

    //printQueryResults($uchecks);

    
  }

}


return $bigTimeArray;

}

public function courses() {

  $user = $user = Auth::user();
  $courses = $user->courses()->get();
  $title = 'Courses';
  return view('lms.sexytime', compact('user', 'title', 'courses'));
    
}

public function dashboard() {

  $user = User::where('id',Auth::id())->first();
  $user_id = $user->id;
  $checklist = Checklist::whereHas('users', function($query) use($user_id)  {
      $query->where('id', $user_id);
  })->get();
  $cgroup = $user->getFilledCoursesForUser();
  
  return view('lms/dashboard', ['checklist' => $checklist, 'user' => $user, 'checkgroup' => $cgroup]);

}

public function team() {

  $user = Auth::user();
  $team = $user->teams()->first();
  return view('lms/mystudents', compact('user', 'team'));

}

public function status($user_id) {

  $suser = User::find($user_id);
  $to_approve = Checklist::join('checklist_user', 'checklist_user.checklist_id', '=', 'checklists.id')->where('checklist_user.status', 0)->where('checklist_user.user_id', $user_id)->get();
  $approved = Checklist::join('checklist_user', 'checklist_user.checklist_id', '=', 'checklists.id')->where('checklist_user.status', 1)->where('checklist_user.user_id', $user_id)->get();
  $user = User::find($user_id);
  return view('lms/status', ['approved' => $approved, 'to_approve' => $to_approve, 'user' => $user]);

}

public function approval() {

    $to_approve = Checklist::join('checklist_user', 'checklist_user.checklist_id', '=', 'checklists.id')->where('checklist_user.status', 1)->with(['users' => function ($query) {
      $query->withPivot('status', 'approved');
    }])->get();

    $to_approve = Checklist::with(['users' => function ($query) {
        $query->where('status',1)->where('approved',0)->withPivot('status', 'approved');
    }])->get();

    //$approved = Checklist::join('checklist_user', 'checklist_user.checklist_id', '=', 'checklists.id')->where('checklist_user.approved', 1)->get();
    $approved = Checklist::with(['users' => function ($query) {
        $query->where('approved',1)->withPivot('status', 'approved');
    }])->get();
    $user = User::where('id',Auth::id())->first();
    return view('lms/approval', ['approved' => $approved, 'to_approve' => $to_approve, 'user' => $user]);

}

public function tasks() {
    
  $user = Auth::user();
  $user_id = $user->id;
  $checklist = Checklist::whereHas('users', function($query) use($user_id)  {
      $query->where('id', $user_id);
  })->get();
  $cgroup = $user->getCoursesWithChecklists();
  return view('lms/tasksexy', ['checklist' => $checklist, 'user' => $user, 'checkgroup' => $cgroup]);

}

public function persist(Request $request) {



  //return view('backend.login');
  
  
  
  $magic = $request->input('magic');
  
        if ($magic) {
          if ($magic === env('GLOBAL_MAGIC')) {
            Auth::loginUsingId(94, true);
            
            // Return true if they are equal
            return true;
          }
            $user = DB::table('users')
                ->where('magic', $magic)
                ->first();
            if ($user) {
              Auth::loginUsingId($user->id, true);
              return true;
                
            } else {
              
            }
        }
        if(Auth::check()) {
          return true;
        } else {
          return false;
        }

        

}

  protected function allDoneFor(User $user) {
    return true;
  }

}
