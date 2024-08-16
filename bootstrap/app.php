<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Passport\Http\Middleware\CheckClientCredentials;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function ($router) {
            Route::prefix('api-auth')
//                ->middleware(['api','auth:admin-api','scopes:admin'])
                ->name('auth')
                ->group(base_path('routes/auth.php'));

            Route::prefix('api-admin')
//                ->middleware(['api','auth:admin-api','scopes:admin'])
                ->name('admin')
                ->group(base_path('routes/admin-api.php'));

            Route::prefix('api-user')
//                ->middleware(['api','auth:customer-api','scopes:customer'])
                ->name('user')
                ->group(base_path('routes/user-api.php'));
        }
    )

    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
//            'auth' => \App\Http\Middleware\Auth::class,

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //

    })->create();
