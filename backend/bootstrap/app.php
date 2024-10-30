<?php

use App\Http\Middleware\FormatResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(FormatResponse::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (BadRequestException $e) {
            return response()->json([
                'error' => 'bad_request',
                'error_ex' => [
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'message' => $e->getMessage(),
                ],
                'result' => []
            ], 400);
        });

        // $this->renderable(function (AuthenticationException $e, Request $request) {
        //     if ($request->is('*/scloby/*')) {
        //         return response()->json([
        //             'status' => 'error',
        //             'error'  => [
        //                 'code' => 401,
        //                 'msg'  => 'Unauthorized'
        //             ]
        //         ], 401);
        //     }
        //     return response()->json([
        //         'error' => 'not_authenticated',
        //         'error_ex' => [
        //             'code' => $e->getCode(),
        //             'file' => $e->getFile(),
        //             'line' => $e->getLine(),
        //             'message' => $e->getMessage(),
        //         ],
        //         'result' => []
        //     ], 401);
        // });

        // $this->renderable(function (UnauthorizedException $e) {
        //     return response()->json([
        //         'error' => 'unauthorized',
        //         'error_ex' => [
        //             'code' => $e->getCode(),
        //             'file' => $e->getFile(),
        //             'line' => $e->getLine(),
        //             'message' => $e->getMessage(),
        //         ],
        //         'result' => []
        //     ], 403);
        // });

        // Resource not found
        $exceptions->renderable(function (NotFoundResourceException $e) {
            return response()->json([
                'error' => 'resource_not_found',
                'error_ex' => [
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'message' => $e->getMessage(),
                ],
                'result' => []
            ], 404);
        });

        // Model not found exception
        $exceptions->renderable(function (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'resource_not_found',
                'error_ex' => [
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'message' => $e->getMessage(),
                ],
                'result' => []
            ], 404);
        });

        // Route not found
        $exceptions->renderable(function (NotFoundHttpException $e) {
            return response()->json([
                'error' => 'route_not_found',
                'error_ex' => [
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'message' => $e->getMessage(),
                ],
                'result' => []
            ], 404);
        });

        // Error not handled
        $exceptions->renderable(function (Throwable $e) {
            return response()->json([
                'error' => 'error_not_handled',
                'error_ex' => [
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ],
                'result' => []
            ], 522);
        });
    })->create();