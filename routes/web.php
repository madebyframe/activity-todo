<?php

use App\Http\Controllers\ToDoTaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


// UI here is the front end

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


// these routes are the API / back end

Route::controller(ToDoTaskController::class)->group( function() {
    Route::get('/todotasks/{showCompleted?}', 'index' );
    Route::post('/todotasks/', 'create' );
    Route::put('/todotask/{task}', 'update');
    Route::delete('/todotask/{task}', 'delete');
});