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
        $exceptions->render(function (\Throwable $e, $request) {
            if ($request->is('api/*') || $request->wantsJson()) {
                $status = 500;
                $message = $e->getMessage() ?: 'Internal server error.';
                $errors = null;

                if ($e instanceof ValidationException) {
                    $status = 422;
                    $message = 'The given data was invalid.';
                    $flatErrors = [];
                    foreach ($e->errors() as $messages) {
                        foreach ($messages as $msg) {
                            $flatErrors[] = $msg;
                        }
                    }
                    $errors = $flatErrors;
                } elseif ($e instanceof NotFoundHttpException) {
                    $status = 404;
                    $message = 'Resource not found.';
                } elseif ($e instanceof MethodNotAllowedHttpException) {
                    $status = 405;
                    $message = 'Method not allowed.';
                } else {
                    if (method_exists($e, 'getStatusCode')) {
                        $status = $e->getStatusCode();
                    } elseif (method_exists($e, 'getCode') && $e->getCode() >= 400 && $e->getCode() < 600) {
                        $status = $e->getCode();
                    }
                }

                return response()->json([
                    'status'  => 'error',
                    'message' => $message,
                    'data'    => null,
                    'errors'  => $errors,
                ], $status);
            }
        });
    })->create();
