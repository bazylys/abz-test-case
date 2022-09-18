<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoAccessTokenProvidedException extends Exception
{
    public function render(Request $request)
    {
        if ($request->expectsJson()) {
            return apiFormatResponse(
                code: Response::HTTP_UNAUTHORIZED,
                data: [
                    'message' => 'No Auth token provided',
                ],
                status: false,
            );
        }
    }
}
