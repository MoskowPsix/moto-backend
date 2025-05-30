<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app =  Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'email_verification' => \App\Http\Middleware\VerificationEmailMiddlaware::class,
            'phone_verification' => \App\Http\Middleware\PhoneVerificationMiddleware::class,
            'email_or_phone_phone_verification' => \App\Http\Middleware\EnsureEmailOrPhoneVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
//    $app->register(\Barryvdh\DomPDF\ServiceProvider::class);
//    $app->configure('dompdf');
return $app;
