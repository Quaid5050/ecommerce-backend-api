<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;
Route::get('/', function () {
    return response()->json(['message' => 'Auth Api Test: localhost:8000/auth-api']);
});

Route::group(['prefix' => 'user'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'registerWithCredentials']);
    Route::post('/oauth', [AuthController::class, 'registerWithOAuth']);
    Route::get('/user-details', [AuthController::class, 'user'])->middleware('auth:api');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
});
