<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\TrustProxies;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // 信任所有代理，让 Laravel 使用穿透工具的真实 Host 头
        TrustProxies::at('*');
        $middleware->prepend(TrustProxies::class);

        $middleware->alias([
            'admin.auth' => \App\Http\Middleware\AdminAuth::class,
            'learn.auth' => \App\Http\Middleware\LearnAuth::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
