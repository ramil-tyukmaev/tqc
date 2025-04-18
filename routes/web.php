<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return phpinfo();
})->withoutMiddleware([\Illuminate\Session\Middleware\StartSession::class, \Illuminate\View\Middleware\ShareErrorsFromSession::class, \Illuminate\Cookie\Middleware\EncryptCookies::class, \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
