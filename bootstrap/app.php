<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'student' => \App\Http\Middleware\StudentMiddleware::class,
            'admin'   => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        // When a logged-in user tries to visit a guest-only page (e.g. /login via back button),
        // redirect them to the correct dashboard based on their role.
        $middleware->redirectUsersTo(function () {
            if (auth()->check()) {
                return auth()->user()->is_admin
                    ? route('admin.dashboard')
                    : route('student.dashboard');
            }
            return route('login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();