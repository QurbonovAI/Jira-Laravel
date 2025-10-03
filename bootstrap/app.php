<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\AdminMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // alias qo‘shish
        $middleware->alias([
            'admin' => AdminMiddleware::class,
        ]);

        // agar global qo‘shmoqchi bo‘lsang:
        // $middleware->append(AdminMiddleware::class);

        // agar faqat web guruhida ishlatsang:
        // $middleware->web(append: [AdminMiddleware::class]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
