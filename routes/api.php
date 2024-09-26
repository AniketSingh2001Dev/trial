<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\OAuthClientController;
use App\Http\Controllers\Api\PostController;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('signup', [AccountController::class, 'signup']);
Route::post('signin', [AccountController::class, 'signin']);
Route::post('signout', [AccountController::class, 'signout'])->middleware('auth:api');
Route::apiResource('posts', PostController::class)->middleware('auth:api');

Route::post('/oauth/client/create', [OAuthClientController::class, 'create']);

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');