<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware; // <-- ¡Añade esta línea!

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Aquí puedes configurar middlewares globales
        // $middleware->web(append: [
        //     \App\Http\Middleware\TrustProxies::class,
        // ]);

        // Define tus aliases de middleware para las rutas
        $middleware->alias([
            'admin' => AdminMiddleware::class, // <-- ¡Añade esta línea!
            // Si tienes otros aliases, déjalos como están
            // 'auth' => \App\Http\Middleware\Authenticate::class,
            // 'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            // etc.
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
