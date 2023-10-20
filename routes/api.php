<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'prefix' => config('app.api_version'),
    'as' => config('app.api_version'),], function () {
    require __DIR__ . '/auth.php';
    require __DIR__ . '/app.php';
});
