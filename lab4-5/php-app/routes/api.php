<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\SubscriptionController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth.keycloak')->group(function () {
//     Route::apiResource('subscriber', SubscriberController::class);
//     Route::apiResource('subscription', SubscriptionController::class);
// });

Route::middleware('auth.keycloak')->group(function () {
    Route::get('subscribers', [SubscriberController::class, 'index'])
        ->middleware('roles:admin,user');

    Route::get('subscribers/{id}', [SubscriberController::class, 'show'])
        ->middleware('roles:admin');

    Route::post('subscribers', [SubscriberController::class, 'store'])
        ->middleware('roles:admin');

    Route::put('subscribers/{id}', [SubscriberController::class, 'update'])
        ->middleware('roles:admin');

    Route::delete('subscribers/{id}', [SubscriberController::class, 'destroy'])
        ->middleware('roles:admin');


    Route::get('subscriptions', [SubscriptionController::class, 'index'])
        ->middleware('roles:admin,user');

    Route::get('subscriptions/{id}', [SubscriptionController::class, 'show'])
        ->middleware('roles:admin');

    Route::post('subscriptions', [SubscriptionController::class, 'store'])
        ->middleware('roles:admin');

    Route::put('subscriptions/{subscription}', [SubscriptionController::class, 'update'])
        ->middleware('roles:admin');

    Route::delete('subscriptions/{subscription}', [SubscriptionController::class, 'destroy'])
        ->middleware('roles:admin');
});

// Route::resource('subscribers', SubscriberController::class);
// Route::resource('subscriptions', SubscriptionController::class);