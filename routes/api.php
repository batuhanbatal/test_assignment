<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChatControlller;
use App\Http\Controllers\Api\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth', [AuthController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('subscription', [SubscriptionController::class, 'index']);

    Route::middleware('chat.rate.limit')->post('chat', [ChatControlller::class, 'index']);
});
