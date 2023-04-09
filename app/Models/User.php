<?php

namespace App\Models;

use Miljoen\NovaAutofill;
use Miljoen\NovaAutofill\AutofillTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Campaign;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\Checklist;
use App\Notifications\EmailNotifier;
use App\Models\Course;
use Illuminate\Support\Facades\Mail;
use App\Mail\CourseMail;
use App\Mail\GenericMail;
use App\Casts\EncryptedFlexibleCast;
use Illuminate\Support\Collection;


use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Notifiable; 
    //use HasApiTokens, HasFactory, Notifiable, Billable, AutofillTrait;
    //use AutofillTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company_name',
        'mobile',
        'area',
        'address',
        'website_url',
        'company_permalink',
        'profile_image',
        'company_logo',
        'hero_image',
        'contacts_id'
    ];

    protected $table = 'users';

    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'access_codes' => EncryptedFlexibleCast::class
    ];

    public function __construct(array $attributes = [])
    {
        // Generate a random string
        $randomString = $this->generateRandomString();

        // Set the 'magic' column to the random string
        $this->magic = $randomString;

        //parent::__construct($attributes);
    }

    public function getFullUrlAttribute() {

        $url = $this->company_permalink ?? 'No Url set yet';
        if ($url !== 'No Url set yet') {
            $url = route('bdmland', ['compa_perma' => $url]);
        }
        return $url;
        

    }


    static function filterKey(): string
    {
        return 'email';
    }

    function ready() {
        $campaigns = Campaign::where('author_id', $this->id)->get();
        $not_yet = false; 
        foreach($campaigns as $campaign) {
        if(empty($campaign->video_thumbnail)) { $not_yet = true; }
        }

        if($not_yet) { return false; } else { return true; }
    }

    static function autofillModels(): \Illuminate\Support\Collection
    {
        return collect([
            new \App\Models\User(['name' => 'cedric', 'email' => 'cedric@cedric.cedric', 'password' => \Illuminate\Support\Facades\Hash::make('cedric')]),
            new \App\Models\User(['name' => 'yoeri', 'email' => 'yoeri@yoeri.yoeri', 'password' => \Illuminate\Support\Facades\Hash::make('yoeri')])
        ]);
    } 

    public function generateRandomString()
    {
        // Generate a random string
        $randomString = Str::random(32);

        // Return the random string
        return $randomString;
    }
    

    public function getMagicaAttribute() {
        $magic = $this->magic;
        
        if(!empty($this->magic)) {
            
            return $this->magic;
        } else {
            $rString = $this->generateRandomString();
            //$this->magic = $rString;
            //$this->update(['magic' => $rString]);
            $this->magic = $rString;
            $this->save();
            return $rString;
        }
    }

    public function contacts()
    {
        return $this->belongsTo(Contact::class);
    } 

    public function courses() {
        return $this->belongsToMany(Course::class, 'course_user');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function checklists() {
        return $this->belongsToMany(Checklist::class, 'checklist_user', 'user_id', 'checklist_id')->withPivot('status', 'approved');
    }

    public function vlessons() {
        return $this->belongsToMany(Vlesson::class, 'vlesson_user', 'user_id', 'vlessons_id')->withPivot('watched');
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'author_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role)
    {
    return $this->roles()->where('key', $role)->exists();
    }

    public function getChecklistForUserFromCourse($course_id) {

        $user_id = $this->id;
        $course = Course::find($course_id);

        $lessonIds = $course->getLessonsIDsBy($this); // Call the getLessonsBy() function on the Course model
            
            // Check if there are any Checklist models with a BelongsTo relation to the Vlessons returned by getLessonsBy()
        $checklists = Checklist::whereHas('vlessons', function ($query) use ($lessonIds) {
            $query->whereIn('id', $lessonIds);
        })->whereHas('users', function($query) {
            $query->where('id', $this->id);
        })->get();
        

        return $checklists;

    }

    public function getCoursesWithChecklists() {
        $courses = $this->courses; // Assuming that the courses() method is defined in the User model
        $coursesWithLessons = [];
    
        foreach ($courses as $course) {
        $lessonIds = $course->getLessonsIDsBy($this); // Call the getLessonsBy() function on the Course model
        
        
        // Check if there are any Checklist models with a BelongsTo relation to the Vlessons returned by getLessonsBy()
        $checklists = Checklist::whereHas('vlessons', function ($query) use ($lessonIds) {
            $query->whereIn('id', $lessonIds);
        })->whereHas('users', function($query) {
            $query->where('id', $this->id);
        })->get();
        
        if ($checklists->count() > 0) { // Check if there are any checklists
            $coursesWithLessons[] = $course; // Add the course to the array of courses with lessons
        }
    }
    
    return $coursesWithLessons;
    }

    public function getLessonsforUserFromCourse($course_id, $checklists=false) {

        $user_id = $this->id;
        $minutes = 120;

        

        $lessons = Cache::remember("user-lessons-$user_id", $minutes, function() use ($user_id, $course_id) {
            // If the data is not present in the cache, retrieve it from the database
            return Vlesson::whereHas('courses', function($query) use($course_id) {
                $query->where('id', $course_id);
            })->whereHas('users', function($query) use ($user_id) {
                $query->where('id', $user_id);
        })->orderBy('order_column')->get();
        });

        if($checklists == true) {
            $lessons = Vlesson::with(['checklists' => function ($query) use ($user_id) {
                $query->whereHas('users', function ($query) use ($user_id) {
                    $query->where('id', $this->id);
                });
            }
            ])->get();
        }



  
        return $lessons;
    }

    public function isRole($role)
    {
        return $this->role === $role;
    }

    public function attachVlessons($vlessonIds)
    {

        $vlessons = Vlesson::find($vlessonIds);

        foreach ($vlessons as $vlesson) {
            $this->vlessons()->attach($vlesson);
            //event(new VlessonAttached($this, $vlesson));
            $this->notify(new EmailNotifier('emails.lesson-assigned', ['subject' => 'New Lesson Assigned', 'user' => $this, 'lesson' => $vlesson]));
        }
    }


    /* Provide an explanation of how to attach lessons to courses attached to a user */

    public function getNextVlessonForUser($course_id, $current_lesson_id) {

        $user_id = $this->id;
        $minutes = 120;

        $lessons = Vlesson::whereHas('courses', function($query) use($course_id) {
            $query->where('id', $course_id);
        })->whereHas('users', function($query) use ($user_id) {
            $query->where('id', $user_id);
        })->orderBy('order_column')->get();

        foreach ($lessons as $index => $lesson) {

            if($lesson->id === $current_lesson_id) {
                if ($index === $lessons->count() - 1) {
                    return '/dashboard';
                } else {
                    return route('ovlesson', ['perma' => $lessons->get($index + 1)->permalink]);
                    //return '/ovlesson/'.$lessons->get($index + 1)->permalink;
                }
            }

        }
        
    }

    public function doneAndDusted()
    {
        // Check the cache for a value with the key "done_and_dusted_{user_id}"
        //if (Cache::has("done_and_dusted_{$this->id}")) {
            // Return the cached value if it exists
        //    return Cache::get("done_and_dusted_{$this->id}");
       // }

        // Check if all checklist items for the user are completed
        $checklistCompleted = DB::table('checklist_user')
            ->where('user_id', $this->id)
            ->where('status', 1)
            ->count() == DB::table('checklist_user')->where('user_id', $this->id)->count();

        // Check if all video lessons for the user have been watched
        $lessonsWatched = DB::table('vlesson_user')
            ->where('user_id', $this->id)
            ->where('watched', 1)
            ->count() == DB::table('vlesson_user')->where('user_id', $this->id)->count();

        // Store the value in the cache with a expiration time of 120 minutes
        Cache::put("done_and_dusted_{$this->id}", $checklistCompleted && $lessonsWatched, 120);

        // Return the value
        return $checklistCompleted && $lessonsWatched;
    }

    public function getFilledCoursesForUser() {



        $minutes = 120;
        $user_id = $this->id;

        return Course::whereHas('users', function($query) use($user_id) {
            $query->where('id', $user_id);
          })->whereHas('vlessons.users', function($query) use($user_id) {
            $query->where('vlesson_user.user_id', $user_id);
          })->get();
      }

      public function teams() {
        return $this->hasMany(Team::class);
      }

      public function getCheckListsIn(Course $course) {
            
            $lessonIds = $course->getLessonsIDsBy($this); // Call the getLessonsBy() function on the Course model
                
            // Check if there are any Checklist models with a BelongsTo relation to the Vlessons returned by getLessonsBy()
            $checklists = Checklist::whereHas('vlessons', function ($query) use ($lessonIds) {
                $query->whereIn('id', $lessonIds);
            })->whereHas('users', function($query) {
                $query->where('id', $this->id);
            })->get();
            
    
            return $checklists;
      }

      public function emailLessonsAndChecklistsFor($course) {
        $course = Course::find($course->id);
        $checklists = $this->getChecklistsIn($course);
        $lessons = $course->getLessonsBy($this);
        Mail::to($this->email)->send(new CourseMail($this,$course, $lessons, $checklists));
        //$this->notify(new CourseNotification($course));
      }

      public function isFinished()
    {
        // Check if all videos have been watched
        $watchedVideos = $this->vlessons()->wherePivot('watched', 1)->count();
        $totalVideos = $this->vlessons()->count();
        
        
        if ($watchedVideos !== $totalVideos) {
            return false;
        }

        // Check if all checklists have been checked
        $completedChecklists = $this->checklists()->wherePivot('status', 1)->count();
        $totalChecklists = $this->checklists()->count();
        
        
        if ($completedChecklists !== $totalChecklists) {
            return false;
        }

        Mail::to('enquiries@headstudios.com.au')->send(new GenericMail($this, 'He Did It!', 'emails.lms.finished'));
        return true;
    }

    public function isBoss() {
        if ($this->role === 'boss') {
            return true;
        } else {
            return false;
        }
    }

    public function isBDM() {
        if ($this->role === 'bdm') {
            return true;
        } else {
            return false;
        }
    }

    /*public function getAccessorCodesAttribute($value)
    {
        // Decode the JSON string into an array of values
        /*
        $accessCodes = json_decode($value, true);

        // Modify the access codes as required
        foreach ($accessCodes as &$code) {
            // Modify the password field
            $code['code']['Password'] = '********';
        }

        // Encode the modified access codes back into a JSON string
        return json_encode($accessCodes); 

        
        

        return (string) $value; */

        /*

        

        $value = json_decode($value);

        

        
        if(isset($value)) {
        foreach($value as $row) {
            
            //
            $password = $row->attributes->password;
            $row->attributes->password = $password.'pooka mooka';
        }
    }

        return $value;
    } */ 

    public function getCodeCollection(): Collection
    {
         return new Collection(
              isset($this->attributes['access_codes']) 
              ? json_decode($this->attributes['access_codes'], false) 
              : []
         );
    }


}
