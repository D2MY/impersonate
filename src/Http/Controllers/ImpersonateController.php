<?php

namespace D2my\Impersonate\Http\Controllers;

use D2my\Impersonate\Services\ImpersonateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

final class ImpersonateController
{
    /**
     * @param  ImpersonateService  $service
     */
    public function __construct(private readonly ImpersonateService $service) {}

    /**
     * @param  Request  $request
     * @param  mixed  $id
     * @return RedirectResponse
     */
    public function login(Request $request, mixed $id): RedirectResponse
    {
        $token = $this->service->getToken();

        if (config('impersonate.logging.enable')) {
            Log::channel(config('impersonate.logging.channel'))
                ->info('Impersonate login. Admin - '.Auth::guard(config('impersonate.user_guard'))->id().'. User - '.$id);
        }

        $this->service->store($id, Auth::guard(config('impersonate.user_guard'))->id(), $token);

        $this->service->logout($request);

        $this->service->setCookie($token);

        $this->service->login($id);

        return redirect($request->query('redirect_to', config('impersonate.route.login.redirect')));
    }

    /**
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        $user = Auth::guard(config('impersonate.user_guard'))->id();

        $this->service->logout($request);

        $id = $this->service->getIdByToken(Cookie::get('impersonate_token'), (bool)config('impersonate.delete_after_logout'));

        if (config('impersonate.logging.enable')) {
            Log::channel(config('impersonate.logging.channel'))->info('Impersonate logout. Admin - ' . $id . '. User - ' . $user);
        }

        $this->service->unsetCookie();

        $this->service->login($id);

        return redirect($request->query('redirect_to', config('impersonate.route.logout.redirect')));
    }
}