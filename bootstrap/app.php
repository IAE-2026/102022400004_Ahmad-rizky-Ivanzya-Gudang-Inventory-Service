<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'iae.key' => \App\Http\Middleware\CheckApiKey::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Standardize exception responses for API routes to IAE-T2 wrapper format
        $exceptions->render(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Resource not found.',
                    'errors'  => null,
                ], 404);
            }
        });

        $exceptions->render(function (MethodNotAllowedHttpException $e, $request) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Method not allowed.',
                    'errors'  => null,
                ], 405);
            }
        });

        $exceptions->render(function (ValidationException $e, $request) {
            if ($request->is('api/*') || $request->wantsJson()) {
                $flatErrors = [];
                foreach ($e->errors() as $messages) {
                    foreach ($messages as $msg) {
                        $flatErrors[] = $msg;
                    }
                }
                return response()->json([
                    'status'  => 'error',
                    'message' => 'The given data was invalid.',
                    'errors'  => $flatErrors,
                ], 422);
            }
        });
    })->create();
