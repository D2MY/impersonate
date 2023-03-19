<?php

namespace D2my\Impersonate\Http\Middleware;

use Closure;
use D2my\Impersonate\Services\ImpersonateService;
use Illuminate\Http\RedirectResponse;

class ImpersonateLogout
{
    /**
     * @param  $request
     * @param  Closure  $next
     * @return RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->hasCookie('impersonate_token') && app(ImpersonateService::class)->existsByToken($request->cookie('impersonate_token'))) {
            return $next($request);
        }

        return back()->with('error', 'Invalid impersonate token');
    }
}
