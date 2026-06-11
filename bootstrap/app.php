<?php

use App\Http\Middleware\AuthenticateAdmin;
use App\Http\Middleware\AuthenticateUser;
use App\Http\Middleware\RedirectIfAdmin;
use App\Http\Middleware\RedirectIfUser;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Enregistrement des aliases
        $middleware->alias([
            'auth.admin'       => AuthenticateAdmin::class,
            'auth.user'        => AuthenticateUser::class,
            'guest.admin'      => RedirectIfAdmin::class,
            'guest.user'       => RedirectIfUser::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
