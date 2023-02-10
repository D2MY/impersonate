<?php

namespace D2my\Impersonate\Services;

use D2my\Impersonate\Repositories\ImpersonateRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

final class ImpersonateService
{
    /**
     * @param  ImpersonateRepository  $repository
     */
    public function __construct(private readonly ImpersonateRepository $repository) {}

    /**
     * @return string
     */
    public function getToken(): string
    {
        return Hash::make(now());
    }

    /**
     * @param  mixed  $user
     * @param  mixed  $admin
     * @param  string  $token
     * @return void
     */
    public function store(mixed $user, mixed $admin, string $token): void
    {
        $this->repository->store($user, $admin, $token);
    }

    /**
     * @param  Request  $request
     * @return void
     */
    public function logout(Request $request): void
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }

    /**
     * @param  mixed  $id
     * @return void
     */
    public function login(mixed $id): void
    {
        Auth::loginUsingId($id, true);
    }

    /**
     * @param  string  $token
     * @return void
     */
    public function setCookie(string $token): void
    {
        Cookie::queue(Cookie::make('impersonate_token', $token));
    }

    /**
     * @param  string  $token
     * @param  bool  $delete
     * @return mixed
     */
    public function getIdByToken(string $token, bool $delete): mixed
    {
        return $this->repository->getByToken($token, $delete)->admin;
    }

    /**
     * @return void
     */
    public function unsetCookie(): void
    {
        Cookie::forget('impersonate_token');
    }

    /**
     * @param  string  $token
     * @return bool
     */
    public function existsByToken(string $token): bool
    {
        return $this->repository->existsByToken($token);
    }
}