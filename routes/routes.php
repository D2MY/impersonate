<?php

use D2my\Impersonate\Http\Controllers\ImpersonateController;
use Illuminate\Support\Facades\Route;

Route::post('_impersonate/{id}', [ImpersonateController::class, 'login'])->name(config('impersonate.route.login.name'))->middleware(config('impersonate.route.login.middleware'));
Route::delete('_impersonate', [ImpersonateController::class, 'logout'])->name(config('impersonate.route.logout.name'))->middleware(config('impersonate.route.logout.middleware'));
