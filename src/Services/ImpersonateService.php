<?php

namespace D2my\Impersonate\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

final class ImpersonateService
{
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
        DB::connection(config('impersonate.connection'))
            ->table(config('impersonate.table.name'))
            ->insert([
                'user' => $user,
                'admin' => $admin,
                'token' => $token
            ]);
    }

    /**
     * @param  Request  $request
     * @return void
     */
    public function logout(Request $request): void
    {
        Auth::guard(config('impersonate.user_guard'))->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }

    /**
     * @param  mixed  $id
     * @return void
     */
    public function login(mixed $id): void
    {
        Auth::guard(config('impersonate.user_guard'))->loginUsingId($id, true);
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
        $result = DB::connection(config('impersonate.connection'))
            ->table(config('impersonate.table.name'))
            ->where('token', $token)
            ->first()
            ->admin;

        if ($delete) {
            DB::connection(config('impersonate.connection'))
                ->table(config('impersonate.table.name'))
                ->where('token', $token)
                ->delete();
        }

        return $result;
    }

    /**
     * @return void
     */
    public function unsetCookie(): void
    {
        Cookie::queue(Cookie::forget('impersonate_token'));
    }

    /**
     * @param  string  $token
     * @return bool
     */
    public function existsByToken(string $token): bool
    {
        return
            DB::connection(config('impersonate.connection'))
                ->table(config('impersonate.table.name'))
                ->where('token', $token)
                ->exists();
    }
}