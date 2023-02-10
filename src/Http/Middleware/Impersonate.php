<?php

namespace D2my\Impersonate\Http\Middleware;

use D2my\Impersonate\Services\ImpersonateService;
use Illuminate\Support\Facades\Cookie;

class Impersonate
{
    public function handle($request, $next)
    {
        if (app(ImpersonateService::class)->existsByToken(Cookie::get('impersonate_token'))) {
            return $next($request);
        }

        return back();
    }
}