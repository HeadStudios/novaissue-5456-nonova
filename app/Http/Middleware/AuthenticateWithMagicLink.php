<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\MagicLink;

class AuthenticateWithMagicLink
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
        if ($request->has('magic_token')) {
            $magicLink = MagicLink::where('token', $request->magic_token)->first();

            if ($magicLink && $magicLink->isValid()) {
                Auth::login($magicLink->user);
                $magicLink->delete();

                return redirect()->intended('/nova'); // Redirect to the desired Nova resource
            }

            return abort(403, 'Invalid or expired magic link.');
        }

        return $next($request);
    }
}
