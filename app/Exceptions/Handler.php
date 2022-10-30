<?php

namespace App\Exceptions;

use App\Utils\ApiResponseTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponseTrait;
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
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            if ($exception instanceof NotFoundHttpException) {

                return $this->apiResponse(
                    [
                        'success' => false,
                        'message' => 'No se encontro la ruta especificada: ' . $request->path(),
                        'exception' => $exception
                    ],
                    $exception->getStatusCode()
                );
            }
            if ($exception instanceof MethodNotAllowedHttpException) {

                return $this->apiResponse(
                    [
                        'success' => false,
                        'message' => 'El método ' . $request->method() . " no esta permitido en esta ruta.",
                        'exception' => $exception
                    ],
                    $exception->getStatusCode()
                );
            }

            if ($exception instanceof PostTooLargeException) {
                return $this->apiResponse(
                    [
                        'success' => false,
                        'message' => "Size of attached file should be less " . ini_get("upload_max_filesize") . "B"
                    ],
                    400
                );
            }

            if ($exception instanceof AuthenticationException) {
                return $this->apiResponse(
                    [
                        'success' => false,
                        'message' => 'No estás autenticado.'
                    ],
                    401
                );
            }
            if ($exception instanceof ThrottleRequestsException) {
                return $this->apiResponse(
                    [
                        'success' => false,
                        'message' => 'Usted realizó muchas peticiones. Vamo a calmarno!'
                    ],
                    429
                );
            }
            if ($exception instanceof ModelNotFoundException) {
                return $this->apiResponse(
                    [
                        'success' => false,
                        'message' => 'Modelo ' . str_replace('App\\', '', $exception->getIds()) . ' no encontrado'
                    ],
                    404
                );
            }
            if ($exception instanceof ValidationException) {

                return $this->apiResponse(
                    [
                        'success' => false,
                        'message' => $exception->getMessage(),
                        'errors' => $exception->errors()
                    ],
                    422
                );
            }
            if ($exception instanceof QueryException) {

                return $this->apiResponse(
                    [
                        'success' => false,
                        'message' => 'Hubo un problema en la ejecucion de la consulta a la Base de datos.',
                        'exception' => $exception

                    ],
                    500
                );
            }
            // if ($exception instanceof \Error) {
            return $this->apiResponse(
                [
                    'success' => false,
                    'message' => "Error en la Matrix. Vuelva mas tarde: ".$exception->getMessage(),
                    'exception' => $exception
                ],
                500
            );
            // }
        }


        return parent::render($request, $exception);
    }
}
