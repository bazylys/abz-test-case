<?php

if (! function_exists('apiFormatResponse')) {

    function apiFormatResponse($code = 200, $data = [], $status = null )
    {
        if (isset($status)) {
            $data = array_merge([
                'success' => $status ? 'success' : 'false',
            ], $data);
        }

        return response()->json($data, $code);
    }

}
