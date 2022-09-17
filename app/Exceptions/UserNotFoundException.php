<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserNotFoundException extends Exception
{
    public function render(Request $request)
    {
        if ($request->expectsJson()) {
            return apiFormatResponse(
                code: Response::HTTP_NOT_FOUND,
                data: [
                    'message' => 'The user with the requested identifier does not exist',
                    'fails' => [
                        'user_id' => [
                            'User not found',
                        ]
                    ]
                ],
                status: false,
            );
        }
    }
}
