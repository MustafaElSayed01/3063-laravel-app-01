<?php

use App\Http\Middleware\HasRolesMiddleware;
use App\Http\Middleware\IsActiveMiddleware;
use App\Http\Middleware\tokenTypeMiddleware;
use App\Http\Middleware\verifiedEmailMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'hasRoles' => HasRolesMiddleware::class,
            'isActive' => IsActiveMiddleware::class,
            'tokenType' => tokenTypeMiddleware::class,
            'verifiedEmail' => verifiedEmailMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
