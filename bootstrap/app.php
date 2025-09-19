<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\SecurityHeaders;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Global middleware
        $middleware->append(SecurityHeaders::class);
        
        // Middleware aliases
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'security' => SecurityHeaders::class,
        ]);
        
        // Rate limiting
        $middleware->throttleApi('60,1'); // 60 requests per minute for API
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
