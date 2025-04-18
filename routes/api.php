<?php

use App\Http\Controllers\TaskController;
use App\Http\Middleware\ApiKeyCheck;
use Illuminate\Support\Facades\Route;

Route::middleware([ApiKeyCheck::class])->group(function () {
    Route::post('/v1/tasks', [TaskController::class, 'create']);
});
