<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class MagicStick
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
        
        
        $magic = $request->query('magic');
        
        // Check if there is a user with a matching magic column value
        $user = \App\Models\User::where('magic', $magic)->first();
        
        if ($user ) {
            // Log the user in
            //\Illuminate\Support\Facades\Auth::login($user);
            auth()->login($user);
            $request->session()->put('user', 69);
            
        } else { 
            $request->session()->put('user', 68);
            
            return \Illuminate\Support\Facades\Redirect::route('login');
        }
        
        
        return $next($request);
    }
}
