<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserWithThisDataAlreadyExistsException extends Exception
{
    public function render(Request $request)
    {
        if ($request->expectsJson()) {
            return apiFormatResponse(
                code: Response::HTTP_CONFLICT,
                data: [
                    'message' => 'User with this phone or email already exist',
                ],
                status: false,
            );
        }
    }
}
