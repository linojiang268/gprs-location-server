<?php
namespace GL\Http\Responses;

trait RespondsJson
{
    /**
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function json(array $data)
    {
        return response()->json(array_merge([
            'status' => 0,
        ], $data));
    }

    /**
     * @param $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonException($message, $code = 10000)
    {
        return response()->json([
            'status'  => $code,
            'message' => $message ?: 'Error.',
        ]);
    }
}