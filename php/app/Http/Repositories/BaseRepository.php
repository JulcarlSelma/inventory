<?php

namespace App\Http\Repositories;
use Symfony\Component\HttpFoundation\Response;

class BaseRepository {
    protected $model = null;
    protected $models = [];
    protected $badRequest = Response::HTTP_BAD_REQUEST;
    protected $internalServerError = Response::HTTP_INTERNAL_SERVER_ERROR;
    protected $notFound = Response::HTTP_NOT_FOUND;


    public function success($data, $message = '', $statusCode = 200)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'errors' => null,
        ], $statusCode);
    }

    public function error($error = '', $errors = [], $statusCode = 500)
    {
        return response()->json([
            'data' => null,
            'message' => $error,
            'errors' => $errors,
        ], $statusCode);
    }
}