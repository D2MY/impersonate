<?php

use D2my\Impersonate\Http\Controllers\ImpersonateController;
use D2my\Impersonate\Http\Middleware\Impersonate;
use Illuminate\Support\Facades\Route;

Route::post('_impersonate/{id}', [ImpersonateController::class, 'login'])->middleware(config('impersonate.login_middleware', Impersonate::class))->name(config('impersonate.login_name', 'impersonate.login'));
Route::delete('_impersonate', [ImpersonateController::class, 'logout'])->middleware(config('impersonate.logout_middleware', Impersonate::class))->name(config('impersonate.logout_name', 'impersonate.logout'));
