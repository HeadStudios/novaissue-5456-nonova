<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Course;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

      

        if ($request->routeIs('course')) {

            $course = Course::where('permalink', $request->route('perma'))
                                ->where('public', 1)
                                ->first();
            if(isset($course)) {
                Auth::loginUsingId(94, true);
                return $next($request);
            }

        }

        $magic = $request->input('magic');
        if ($magic) {
            session(['magica' => $magic]);
            /*$user = DB::table('users')
                ->where('magic', $magic)
                ->first();
            if ($user) {
              Auth::loginUsingId($user->id, true);
            
                
            } else {
              
            }*/
            return $next($request);
        }

        if (!Auth::check()) {
            
            return redirect('/login');
        }
 
        return $next($request);
    }
}
