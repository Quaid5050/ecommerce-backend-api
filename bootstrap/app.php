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
                ->group(base_path('routes/auth.php'));

            Route::prefix('api-admin')
//                ->middleware(['api','auth:admin-api','scopes:admin'])
                ->group(base_path('routes/admin-api.php'));

            Route::prefix('api-user')
                ->group(base_path('routes/user-api.php'));
        }
    )

    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append([
//            \App\Http\Middleware\ClientMiddleware::class,
            \App\Http\Middleware\ForceJsonResponse::class,
        ]);
        $middleware->alias([
//            'auth' => \App\Http\Middleware\Auth::class,

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //

    })->create();
