<?php

namespace GL\Exceptions;

use Exception;
use GL\Http\Responses\RespondsJson;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    use RespondsJson;

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $ex
     * @return Response
     */
    public function render($request, Exception $ex)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return $this->renderAsJson($request, $ex);
        }

        return parent::render($request, $ex);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request  $request
     * @param Exception $ex
     * @return mixed
     */
    private function renderAsJson(Request $request, Exception $ex)
    {
        if ($ex instanceof TokenMismatchException) {
            return $this->jsonException('mismatch');
        } else if ($ex instanceof ValidationException) {
            return $this->jsonException($ex->errors() ? array_first($ex->errors())[0] : $ex->getMessage(), ExceptionCode::INVALID_PARAMS);
        }

        return $this->jsonException($ex->getTrace(), ($ex->getCode() && is_int($ex->getCode())) ? $ex->getCode() : ExceptionCode::GENERAL);
    }
}
