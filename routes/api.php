<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\DamageReportController;

/*
|--------------------------------------------------------------------------
| USERS API
|--------------------------------------------------------------------------
*/
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::patch('/{id}/disable', [UserController::class, 'disable']);
    Route::post('/{id}/reset-password', [UserController::class, 'resetPassword']);
});

/*
|--------------------------------------------------------------------------
| DAMAGE REPORTS API
|--------------------------------------------------------------------------
*/
Route::prefix('reports')->group(function () {
    Route::get('/', [DamageReportController::class, 'index']);          // list + filter
    Route::get('/latest', [DamageReportController::class, 'latest']);    // dashboard widget
    Route::get('/{id}', [DamageReportController::class, 'show']);        // detail

    Route::patch('/{id}/approve', [DamageReportController::class, 'approve']);
    Route::patch('/{id}/reject', [DamageReportController::class, 'reject']);
});