<?php

namespace D2my\Impersonate\Models;

use Illuminate\Database\Eloquent\Model;

final class ImpersonateToken extends Model
{
    protected $table = 'impersonate_token';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'admin',
        'user',
        'token',
    ];

    protected $hidden = [
        'token',
    ];
}