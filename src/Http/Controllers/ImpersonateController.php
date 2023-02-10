<?php

namespace D2my\Impersonate\Http\Controllers;

use D2my\Impersonate\Services\ImpersonateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

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

        $this->service->store($id, Auth::id(), $token);

        $this->service->logout($request);

        $this->service->setCookie($id);

        $this->service->login($id);

        return redirect()->route(config('impersonate.login_redirect'));
    }

    /**
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        $this->service->logout($request);

        $id = $this->service->getIdByToken(Cookie::get('impersonate_token'), (bool)config('impersonate.delete_after_logout', true));

        $this->service->unsetCookie();

        $this->service->login($id);

        return redirect()->route(config('impersonate.logout_redirect'));
    }
}