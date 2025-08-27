<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/routes/web.php',
        commands: __DIR__.'/routes/console.php',
        health: '/up',
        then: function () {
            // This allows adding route groups with custom middleware, in this case, for admin routes.
            Route::middleware('web')
                ->prefix('admin')
                ->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Add custom middleware to the "web" group
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        // You can append more middleware here, such as logging or authentication middleware.
        // $middleware->web(append: [\App\Http\Middleware\SomeOtherMiddleware::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Here you can handle exceptions in your application, e.g., logging or custom handling.
        // You can throw custom exceptions or set default behavior.
        $exceptions->renderUsing(function ($exception) {
            return response()->view('errors.custom', ['exception' => $exception], 500);
        });
    })
    ->create();
