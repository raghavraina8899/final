<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class CheckResetToken
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
        $token = $request->query('token');
        $user = User::where('reset_token', $token)
                    ->where('reset_token_expiration', '>', now())
                    ->first();

        if (!$user) {
            return redirect()->route('404.page');
        }

        return $next($request);
    }
}
