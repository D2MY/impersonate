<?php

namespace D2my\Impersonate\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;

class ImpersonateLogin
{
    /**
     * @param  $request
     * @param  Closure  $next
     * @return RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->hasCookie('impersonate_token')) {
            return $next($request);
        }

        return back()->with('error', 'You are already logged in as another user');
    }
}
