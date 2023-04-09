<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Vlesson;

class CheckLessonPublic
{
    public function handle($request, Closure $next)
    {
        $perma = $request->route('perma');
        $lesson = Vlesson::where('permalink', $perma)->first();

        if (!$lesson || !$lesson->public) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}




