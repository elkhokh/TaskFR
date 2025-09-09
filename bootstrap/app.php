<?php

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Application;
use Illuminate\Database\QueryException;
use App\Http\Middleware\LogRequestMiddleware;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->append(LogRequestMiddleware::class); //both
        // $middleware->web(LogRequestMiddleware::class);// only web
        // $middleware->api(LogRequestMiddleware::class); // only api
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                return ApiResponse::error("Validation failed", $e->errors(), 422);
            }
        });
        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            if ($request->is('api/*')) {
                return ApiResponse::error(
                    "Resource not found",
                    ["detail" => "Requested resource not found."],
                    404
                );
            }
        });
        //    to handle  NotFoundHttpException error
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return ApiResponse::error("Endpoint not found", null, 404);
            }
        });
        // to handle ThrottleRequestsException error and many request
        $exceptions->render(function (ThrottleRequestsException $e, Request $request) {
            if ($request->is('api/*')) {
                return ApiResponse::error("Too many requests (login) ", [], 429);
            }
        });
        // SQLite error code 19
        $exceptions->render(function (QueryException $e, Request $request) {
            if ($request->is('api/*')) {
                if (isset($e->errorInfo[1]) && $e->errorInfo[1] == 19) { // unique violation in SQLite
                    return ApiResponse::error(
                        "Duplicate entry detected",
                        ["detail" => "The class name already exists."],
                        409
                    );
                }
            }
        });
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                Log::error($e);
                return ApiResponse::error(
                    "Unexpected error occurred",
                    ["message" => $e->getMessage()],
                    500
                );
            }
        });
    })
    ->create();


