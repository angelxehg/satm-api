<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Traits\ApiResponser;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\AuthenticationException;
use App\Exceptions\NotAdminException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\QueryException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
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
    public function render($request, Exception $exception)
    {
        // Catch exceptions
        if($exception instanceof ValidationException){
            return $this->convertValidationExceptionToResponse($exception,$request);
        }
        if ($exception instanceof ModelNotFoundException) {
            $model = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse("There is no instance of {$model} of the specified id", 404);
        }
        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }
        if ($exception instanceof NotAdminException) {
            return $this->notAdmin($request, $exception);
        }
        if ($exception instanceof AuthorizationException) {
            return $this->errorResponse("You don't have permision to do that", 403);
        }
        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse('URL not Found', 404);
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse('The specified method is not allowed', 405);
        }
        if ($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }
        if ($exception instanceof QueryException) {
            $codigo = $exception->errorInfo[1];
            if ($codigo == 1451) {
                return $this->errorResponse("The resource can't be deleted, because it's related with other resource", 409);
            }
        }
        if (config('app.debug')) {
            return parent::render($request, $exception);
        }
        return $this->errorResponse('Unexpected failure', 500);
    }
    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->errorResponse('No has iniciado sesión', 401);
    }

    protected function notAdmin($request, NotAdminException $exception)
    {
        return $this->errorResponse("No tienes permiso para esto", 401);
    }
     /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    protected function convertValidationExceptionToResponse(ValidationException $e, $request){
        $errors = $e->validator->errors()->getMessages();
        return $this->errorDataResponse("Error de validación de campos", $errors, 422);
    }
}
