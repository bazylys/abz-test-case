<?php

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

if (!function_exists('apiFormatResponse')) {

    function apiFormatResponse($code = 200, $data = [], $status = null)
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
