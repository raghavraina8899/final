<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PreventUrlChange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the previous URL stored in the session
        $storedUrl = Session::get('current_url');

        // Allow page change via UI by checking the referrer (last visited page)
        $referer = $request->headers->get('referer');

        if ($referer) {
            
            Session::put('current_url', $request->fullUrl());
        } else if ($storedUrl && $request->fullUrl() !== $storedUrl) {
            
            return redirect($storedUrl);
        }

        return $next($request);
    }
}
