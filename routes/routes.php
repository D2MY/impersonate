<?php

use D2my\Impersonate\Http\Controllers\ImpersonateController;
use Illuminate\Support\Facades\Route;

Route::post('_impersonate/{id}', [ImpersonateController::class, 'login'])->name(config('impersonate.login_name', 'impersonate.login'))->middleware(config('impersonate.login_middleware'));
Route::delete('_impersonate', [ImpersonateController::class, 'logout'])->name(config('impersonate.logout_name', 'impersonate.logout'))->middleware(config('impersonate.logout_middleware'));
