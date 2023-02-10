<?php

namespace D2my\Impersonate\Repositories;

use D2my\Impersonate\Models\ImpersonateToken;
use Illuminate\Database\Eloquent\Model;

final class ImpersonateRepository
{
    /**
     * @param  ImpersonateToken  $model
     */
    public function __construct(private readonly ImpersonateToken $model) {}

    /**
     * @param  mixed  $user
     * @param  mixed  $admin
     * @param  string  $token
     * @return void
     */
    public function store(mixed $user, mixed $admin, string $token): void
    {
        $this
            ->model
            ->newQuery()
            ->create([
                'user' => $user,
                'admin' => $admin,
                'token' => $token,
            ]);
    }

    /**
     * @param  string  $token
     * @param  bool  $delete
     * @return Model
     */
    public function getByToken(string $token, bool $delete): Model
    {
        return
            tap(
                $this
                    ->model
                    ->newQuery()
                    ->where('token', $token)
                    ->first(),
                function ($el) use ($delete) {
                    if ($delete && $el instanceof ImpersonateToken) {
                        $el->delete();
                    }
                }
            );
    }

    /**
     * @param  string  $token
     * @return bool
     */
    public function existsByToken(string $token): bool
    {
        return
            $this
                ->model
                ->newQuery()
                ->where('token', $token)
                ->exists();
    }
}