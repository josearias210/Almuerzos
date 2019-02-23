<?php

namespace Alegra\Traits;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait RestExceptionHandlerTrait {

    /**
     * Creates a new JSON response based on exception type.
     *
     * @param Request $request
     * @param Exception $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getJsonResponseForException(Request $request, Exception $e) {
        switch (true) {
            case $this->isModelNotFoundException($e):
                $retval = $this->modelNotFound();
                break;
            default:
                $retval = $this->internalServerError();
        }

        return $retval;
    }

    /**
     * Returns json response for generic bad request.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function badRequest($message = 'Solicitud invalida', $statusCode = 400) {
        return $this->jsonResponse(['error' => $message], $statusCode);
    }

    protected function internalServerError($message = 'Ocurrio un error procesando la solicitud', $statusCode = 500) {
        return $this->jsonResponse(['error' => $message], $statusCode);
    }

    /**
     * Returns json response for Eloquent model not found exception.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function modelNotFound($message = 'Registro no encontrado', $statusCode = 404) {
        return $this->jsonResponse(['error' => $message], $statusCode);
    }

    /**
     * Returns json response.
     *
     * @param array|null $payload
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse(array $payload = null, $statusCode = 404) {
        $payload = $payload ?: [];

        return response()->json($payload, $statusCode);
    }

    /**
     * Determines if the given exception is an Eloquent model not found.
     *
     * @param Exception $e
     * @return bool
     */
    protected function isModelNotFoundException(Exception $e) {
        return $e instanceof ModelNotFoundException;
    }

}
