<?php

use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::prefix('/up2you')->group(function () {
    Route::get('/healthcheck', function () {
        echo "App is running!";
    });

    // TODO Auth Middleware 
    Route::prefix('/events')->group(function () {
        Route::post('/', [EventController::class, 'insert']);
        Route::prefix('/{eventId}')->group(function () {
            Route::get('', [EventController::class, 'get']);
            Route::put('', [EventController::class, 'update']);
            Route::delete('', [EventController::class, 'delete']);
        });
    });
    Route::prefix('/attendees')->group(function () {
        Route::post('/', [EventController::class, 'insert']);
        Route::prefix('/{attendeeId}')->group(function () {
            Route::get('', [AttendeeController::class, 'get']);
            Route::put('', [AttendeeController::class, 'update']);
            Route::delete('', [AttendeeController::class, 'delete']);
        });
    });
});