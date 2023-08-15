<?php

namespace D2my\Impersonate\Http\Middleware;

use Closure;
use D2my\Impersonate\Services\ImpersonateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ImpersonateLogin
{
    /**
     * @param  $request
     * @param  Closure  $next
     * @return RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        if (
            !$request->hasCookie('impersonate_token')
            || app(ImpersonateService::class)->getIdByToken($request->cookie('impersonate_token'), false) === Auth::guard(config('impersonate.user_guard'))->id()
        ) {
            return $next($request);
        }

        return back()->with('error', 'You are already logged in as another user');
    }
}
