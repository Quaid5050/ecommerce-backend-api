<?php

use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\User\Auth\GoogleAuthController;
use App\Http\Controllers\User\Auth\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;


Route::middleware('auth:api')->group(function () {
    Route::post('/user', function (Request $request) {
        return $request->user();
    });
});
Route::post('/userr', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/user-detail', function (Request $request) {
    return auth()->user();
});
//TEST LARAVEL API..
Route::get('/', function () {
    return response()->json(['message' => 'Hello World!']);
});

//Authentication routes
Route::post('admin/register', [AdminAuthController::class, 'register']);
Route::post('admin/login', [AdminAuthController::class, 'login']);

Route::group(['middleware' => ['web']], function () {
    Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle']);
    Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);
});

Route::post('auth/clientAuth', [GoogleAuthController::class, 'clientAuth']);
Route::post('auth/test',[GoogleAuthController::class,"test"]);

Route::post('auth/logout',[GoogleAuthController::class,"logout"])->middleware('auth:api');

Route::post('/products',function (){
    $products = [
        ['id' => 1, 'name' => 'Product 1'],
        ['id' => 2, 'name' => 'Product 2'],
        ['id' => 3, 'name' => 'Product 3'],
        ['id' => 4, 'name' => 'Product 4'],
        ['id' => 5, 'name' => 'Product 6'],
    ];
    return response()->json($products);
})->middleware('auth:api');

//Test the auth2
//Route::post('/register', [Auth::class, 'register']);
//Route::post('/login',[Auth::class, 'login']);
//Route::get('/user',[Auth::class, 'user'])->middleware('auth:api');
//Route::post('/logout',[Auth::class, 'logout'])->middleware('auth:api');
//

//
Route::post('/register1', [AuthController::class, 'registerWithCredentials']);
Route::post('/register2', [AuthController::class, 'registerWithOAuth']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::post('/user', [AuthController::class, 'user'])->middleware('auth:api');
