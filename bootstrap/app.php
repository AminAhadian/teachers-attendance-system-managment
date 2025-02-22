<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $exception, Request $request) {
            if ($exception->getStatusCode() == 400) {
                return response()->view("errors.400", [], 400);
            }

            if ($exception->getStatusCode() == 403) {
                return response()->view("errors.403", [], 403);
            }

            if ($exception->getStatusCode() == 404) {
                return response()->view("errors.404", [], 404);
            }

            if ($exception->getStatusCode() == 500) {
                return response()->view("errors.500", [], 500);
            }

            if ($exception->getStatusCode() == 503) {
                return response()->view("errors.503", [], 503);
            }
        });
    })->create();
