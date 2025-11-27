<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Exceptions\ExceptionHandler;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, Request $request) {
            $className = get_class($e);
            $handlers = ExceptionHandler::$handlers;

            if (array_key_exists($className, $handlers)) {
                $method = $handlers[$className];
                $exceptionHandler = new ExceptionHandler();
                return $exceptionHandler->$method($e, $request);
            }
            
            return response()->json([
                'error' => [
                    'type' => basename(get_class($e)),
                    'status' => $e->getCode() ?: 500,
                    'message' => $e->getMessage() ?: 'Error',
                    'timestamp' => now()->toISOString(),
                    'debug' => app()->environment('local', 'dev') ? [
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'trace' => $e->getTraceAsString(),
                    ] : null,
                ]
            ], $e->getCode() ?: 500);
        });
    })->create();
