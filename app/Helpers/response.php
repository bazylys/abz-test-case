<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

if (!function_exists('apiFormatResponse')) {

    function apiFormatResponse($code = 200, $data = [], $status = null): JsonResponse
    {
        if ($data instanceof JsonResource) {
            $data = $data->response(request())->getData(true);
        }

        if (isset($status)) {
            $data = array_merge([
                'success' => $status,
            ], $data);
        }

        return response()->json($data, $code);
    }

}
