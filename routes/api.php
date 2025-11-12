<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth.token')->group(function () {
    Route::resource('tasks', TaskController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names([
            'index'   => 'tasks',
            'store'   => 'tasks.store',
            'update'  => 'tasks.update',
            'destroy' => 'tasks.destroy',
        ]);;
});

Route::get('/openapi.yaml', function () {
    return response()->file(base_path('api/openapi.yaml'), [
        'Content-Type' => 'application/yaml'
    ]);
});
