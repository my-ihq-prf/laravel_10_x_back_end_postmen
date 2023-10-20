<?php

use App\Http\Controllers\Api\EmailVerificationNotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

Route::middleware('guest:' . config('fortify.guard'))->group(function () {
    // $limiter=config('fortify.limiters.login');
    $limiter = '6,1';
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware(array_filter([
            $limiter ? 'throttle:' . $limiter : null
        ]))->name('api_login');

    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->name('api_password.store');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('api_password.email');
});

Route::middleware(['auth:sanctum', 'throttle:6,1'])->group(function () {
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->name('api_verification.send');

    Route::post('/whoami', function (Request $request) {
        return $request->user();
    });
});
