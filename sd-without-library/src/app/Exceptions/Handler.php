<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        if ($messageError = $this->errorException($e)) {
            return $messageError;
        } else {
            $request->headers->set('Accept', 'application/json');

            return parent::render($request, $e);
        }
    }

    protected function errorException(Throwable $e)
    {
        $error = null;
        if ($e instanceof AuthenticationException) {
            $error = $this->errorResponse('Unauthenticated', Response::HTTP_UNAUTHORIZED);
        } elseif ($e instanceof ModelNotFoundException) {
            $error = $this->errorResponse('Object Not Found', Response::HTTP_NOT_FOUND);
        } elseif ($e instanceof NotFoundHttpException) {
            $error = $this->errorResponse('Url Not Found', Response::HTTP_NOT_FOUND);
        } elseif ($e instanceof HttpException) {
            $error = $this->errorResponse($e->getMessage(), $e->getStatusCode());
        } elseif ($e instanceof AuthorizationException) {
            $error = $this->errorResponse($e->getMessage(), Response::HTTP_FORBIDDEN);
        }

        return $error;
    }

    /**
     * errorResponse
     *
     * @param  mixed  $message
     * @param  mixed  $code
     * @return void
     */
    protected function errorResponse($message, $code)
    {
        return response()->json([
            'error' => $message,
            'code' => $code,
        ], $code);
    }
}
