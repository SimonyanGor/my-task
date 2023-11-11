<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Throwable;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\Exceptions\OAuthServerException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<class-string<Throwable>>
     */
    protected $dontReport = [];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * @param $request
     * @param Throwable $e
     * @return JsonResponse
     * @throws Throwable
     */
    public function render($request, Throwable $e): JsonResponse
    {
        // Handle ValidationException
        if ($e instanceof ValidationException) {
            return response()->json(['error' => $e->validator->errors()], 422);
        }

        // Handle NotFoundHttpException
        if ($e instanceof NotFoundHttpException) {
            return response()->json(['error' => 'Not Found'], 404);
        }


        // Handle OAuthServerException
        if ($e instanceof OAuthServerException) {
            return response()->json(['error' => 'OAuth Server Error'], 500);
        }


        // Handle HttpException
        if ($e instanceof HttpException) {
            return response()->json(['error' => $e->getMessage()], $e->getStatusCode());
        }


        // If none of the above conditions match, let the parent handler handle the exception.
        return parent::render($request, $e);
    }
}
