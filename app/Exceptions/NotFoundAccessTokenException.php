<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotFoundAccessTokenException extends Exception
{
    public function render(Request $request)
    {
        if ($request->expectsJson()) {
            return apiFormatResponse(
                code: Response::HTTP_UNAUTHORIZED,
                data: [
                    'message' => 'Not found provided token',
                ],
                status: false,
            );
        }
    }
}
