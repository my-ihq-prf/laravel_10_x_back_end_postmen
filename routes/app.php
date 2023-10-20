<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'throttle:6,1'])->group(function () {

    Route::controller(SubscriptionController::class)->group(function () {

        Route::get('/subscription', 'show')->name('subscriptions_test_show')
            ->middleware('can:view,App\Models\Subscription');
        Route::post('/subscription', 'create')->name('subscriptions_test_create')
            ->middleware('can:create,App\Models\Subscription');
        Route::put('/subscription' . '/{id}', 'update')->name('subscriptions_test_update')
            ->middleware('can:update,App\Models\Subscription');
        Route::delete('/subscription' . '/{id}', 'delete')->name('subscriptions_test_delete')
            ->middleware('can:delete,App\Models\Subscription');

    });

    Route::controller(ArticleController::class)->group(function () {

        Route::get('/articles', 'show')->name('articles_test_show')
            ->middleware('can:view,App\Models\Article');

        Route::post('/articles', 'create')->name('articles_test_create')
            ->middleware('can:create,App\Models\Article');

        Route::put('/articles' . '/{article}', 'update')->name('articles_test_update')
            ->middleware('can:update,App\Models\Article');

        Route::delete('/articles' . '/{article}', 'delete')->name('articles_test_delete')
            ->middleware('can:delete,App\Models\Article');

    });

});
