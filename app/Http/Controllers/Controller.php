<?php

namespace GL\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function json(array $data)
    {
        return json_encode(array_merge([
            'status' => 0,
        ], $data));
    }

    protected function jsonException($message, $code = 10000)
    {
        return json_encode([
            'status'  => $code,
            'message' => $message ?: 'Error.',
        ]);
    }
}
