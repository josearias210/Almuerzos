<?php

namespace App\Exceptions;

use Exception;
use Alegra\Traits\RestTrait;
use Alegra\Traits\RestExceptionHandlerTrait;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

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

    use RestTrait;
    use RestExceptionHandlerTrait;

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception) {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e) {
        if (!$this->isApiCall($request)) {
            $retval = parent::render($request, $e);
        } else {
            
            $retval = $this->getJsonResponseForException($request, $e);
      
        }

        return $retval;

        /*
          if ($exception instanceof ModelNotFoundException && $request->wantsJson()) {
          return response()->json([
          'error' => 'Resource not found'
          ], 404);
          } */
        /*
          if ($request->ajax() || $request->wantsJson())
          {
          $json = [
          'success' => false,
          'error' => [
          'code' => $e->getCode(),
          'message' => $e->getMessage(),
          ],
          ];
          return response()->json($json, 400);
          }

          return parent::render($request, $exception);
         */
    }

}
