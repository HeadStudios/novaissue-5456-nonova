<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Checklist;
use App\Models\Course;
use App\Models\User;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Vlesson extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    public $table = 'vlessons';

    protected $fillable = ['permalink', 'title', 'video_url'];

    /*public function course() {
        return $this->belongsTo(Course::class);
    }*/

    public function getAssignment($userId)
    {
        $result = DB::table('vlesson_user')
            ->where('user_id', $userId)
            ->where('vlessons_id', $this->id)
            ->whereNotNull('assignment')
            ->where('assignment', '<>', '')
            ->value('assignment');
        dump("The result is : ");
        dump("The ID of the lesson is :".$this->id." and the user id is: ".$userId);
        dump($result);
        
        return $result ?? false;
    }

    public function courses() {
        return $this->belongsToMany(Course::class);
    }

    public function users() {
        return $this->belongsToMany(User::class, 'vlesson_user', 'vlessons_id', 'user_id')->withPivot('watched', 'assignment');;
    }

    public function checklists() {
        return $this->hasMany(Checklist::class, 'vlessons_id');
    }

    public function getUrl($lesson_id) {

        $lesson = Vlesson::find($lesson_id);
        return route('ovlesson', ['perma' => $lesson->permalink]);
        //return '/ovlesson/'.$lesson->permalink;
        //ovlesson
    
      }

      public function getVlessonUrl() {

        //$lesson = Vlesson::find($this->id);
        if($this->permalink) {
          return '/lms/ovlesson/'.$this->permalink; 
        } else {
          return '#'; 
        }
    
      }

      public function getCourseForLesson() {
        $lesson_id = $this->id;
      $course = Course::whereHas('vlesson', function($query) use($lesson_id) {
        $query->where('id', $lesson_id);
      })->first();
  
      return $course;

    }

    public function getFormattedLessonOutlineAttribute($value)
    {

      $value = $this->lesson_outline;


        $replacementFunc = function($pass) {


          
              $user = User::find(Auth::id());
              $field = $user->access_codes;
              $field = $user->getCodeCollection();
          
              
              $all = [];
              if(isset($field)) {
              foreach($field as $one) {
                  $all[] = $one->attributes; //->attributesToArray();
              }
              if($this->searchArray($all, $pass)){
                $val = $this->searchArray($all, $pass);
              return $this->printCodes($val);
              }
              //$all = searchArray($all, 'login_url');
              //echo "We smell it!";
              }
              
              return $user->name;
          };
          
          // Replace the password tag
          return $this->replacePasswordTag($value, $replacementFunc);
    }

    protected function replacePasswordTag($string, $replacementFunc) {
        // Use a regular expression to search for the {{password:pass}} tag
        $pattern = '/\{\{password:(.*?)\}\}/';
      
        // Replace the tag with the value returned by the replacement function
        return preg_replace_callback($pattern, function($matches) use ($replacementFunc) {
          // The value of "pass" is in the first capturing group of the regular expression
          return $replacementFunc($matches[1]);
        }, $string);
      }

      protected function searchArray($arr, $keyword) {
        
        
        
        
        $keyword = strtolower($keyword);
        foreach ($arr as $item) {
          
          
          
          
          if (strpos(strtolower($item->login_url), $keyword) !== false) {
            return $item;
          }
        }
        return false;
      }

      protected function printCodes($arr) {
        $output = '<blockquote><h3>Login Codes</h3><table><tr><th>Type</th><th>Login</th></tr>';
        
        foreach($arr as $key => $one) {
          $formattedKey = str_replace('_', ' ', $key);
          $formattedKey = ucwords($formattedKey);
          $output .= '<tr><td>'.$formattedKey.'</td><td>'.$one.'</td></tr>';
        }
        $output .= '</table></blockquote>';
        return $output;
      }
  
    

   


}
