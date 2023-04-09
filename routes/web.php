<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\PlayAround;
use App\Models\MagicLink;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\VideoAuditController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Laravel\Nova\Notifications\NovaNotification;
use Laravel\Nova\URL;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/notifiya', function (Request $request) {

    $request->user()->notify(
        NovaNotification::make()
            ->message('Your report is ready to download.')
            ->action('Download', URL::remote('https://example.com/report.pdf'))
            ->icon('download')
            ->type('info')
    );

});

Route::get('/', function () {   
    return view('home');
})->name('home')->middleware('cache.headers:public;max_age=3600;etag');

Route::get('audit/{slug}', [VideoAuditController::class, 'show'])->name('audit.show');

Route::get('/arewehere', function() {
    $records = app()->make('SyncMan')->syncAirContacts();
    return $records;

});

Route::get('terms-conditions', function() {

    return view('terms');

})->name('terms');

Route::get('/insight/{perma}', [CampaignController::class, 'vsl']);

Route::get('/insight/{category}/{permalink}', [CampaignController::class, 'landing']);   //->middleware('cache.headers:public;max_age=3600;etag')->name('landing');

//Route::get('/offer/{shortURLKey}', '\AshAllenDesign\ShortURL\Controllers\ShortURLController')->middleware('cache.headers:public;max_age=3600;etag')->name('shortlink');

Route::get('/oauthor', [PlayAround::class, 'oauthor']);

Route::match(['get', 'post'], '/airbooker', [PlayAround::class, 'mailit'])->name('users.update');

Route::get('/proppapoppakoppa', [PlayAround::class, 'updateAustralianContacts']);

Route::get('/airer', [PlayAround::class, 'databaser']);

Route::get('/magic-login/{magic_token}', function (Request $request, $magic_token) {
    $resourceUrl = $request->input('resource_url');

    if (!$resourceUrl) {
        return abort(400, 'Resource URL is required.');
    }

    $magicLink = MagicLink::where('token', $magic_token)->first();

    if ($magicLink && $magicLink->isValid()) {
        Auth::login($magicLink->user);
        $magicLink->delete();

        return redirect($resourceUrl);
    }

    return abort(403, 'Invalid or expired magic link.');
})->name('magic-login');










Route::group(['middleware' => 'token', 'prefix' => '/lms'], function() {
    
    Route::get('/courses',[CourseController::class, 'courses'])->name('courses');

    Route::get('/course/{perma}',[CourseController::class, 'course'])->name('course');

    

    Route::get('/ovlesson/{perma}', [CourseController::class, 'oldvlesson'])->name('ovlesson');

    Route::get('/printc/{uid}/{lid}', [CourseController::class, 'printc'])->name('printc');

    Route::get('/dashboard', [CourseController::class, 'dashboard'])->name('dashboard');

    Route::get('/tasks', [CourseController::class, 'tasks'])->name('tasks');

    Route::get('/team', [CourseController::class, 'team'])->name('team');

    Route::get('/approval', [CourseController::class, 'approval'])->name('approval');

    Route::get('/status/{user_id}', [CourseController::class, 'status'])->name('status');

});

Route::get('/goworty/{perma}', function() {
    return "Go shorty!";
});

Route::get('/login', function() {

    return view('lms/login');

})->name('login');


Route::get('/pricing', function() {

    return view('pricing');

});




Route::get('/vlesson/{perma}', [CourseController::class, 'vlesson'])->middleware('public.lesson');



//Route::get('/vblog/{compa_perma}/{slug}', [CampaignController::class, 'prop_landing']);
Route::get('/vblog/{compa_perma}/{category}/{permalink}', [CampaignController::class, 'prop_landing'])->name('landing');

Route::get('/vblog/{compa_perma}/', [CampaignController::class, 'single'])->name('bdmland');
Route::get('/vblog-staging/{compa_perma}/', [CampaignController::class, 'singlestaging']);

Route::get('/register', function () {
    return view('register');
});

Route::get('/login/google', [PlayAround::class, 'redirectToGoogle']);
Route::get('/login/google/callback', [PlayAround::class, 'handleGoogleCallback']);
Route::get('/timezoner', [PlayAround::class, 'ffmpeger']);

// Stasher