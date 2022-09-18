<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AccessTokenService;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetAccessTokenController extends Controller
{
    use ApiResponseHelpers;

    /**
     * Handle the incoming request.
     *
     * @param  Request  $request
     * @param  AccessTokenService  $service
     * @return JsonResponse
     */
    public function __invoke(Request $request, AccessTokenService $service)
    {
        $token = $service->createToken();

        return apiFormatResponse(
            data: ['token' => $token->token],
            status: true
        );
    }
}
