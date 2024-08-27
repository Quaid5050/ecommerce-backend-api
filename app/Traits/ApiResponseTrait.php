<?php
namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
trait ApiResponseTrait
{
    protected function successResponse(array $data = [], $message = '', $status = 200) : JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ], $status);
    }

    protected function errorResponse($message, $errors = [], $status = 500) : JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors'  => $errors,
        ], $status);
    }

    protected function rollbackResponse($message, $errors = [], $status = 400) : JsonResponse
    {
        DB::rollBack();
        return $this->errorResponse($message, $errors, $status);
    }
}
