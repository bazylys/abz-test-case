<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PositionsCollection;
use App\Contracts\PositionsRepositoryInterface;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GetPositionsController extends Controller
{
    use ApiResponseHelpers;

    /**
     * @param  Request  $request
     * @param  PositionsRepositoryInterface  $repository
     * @return PositionsCollection|JsonResponse
     */
    public function __invoke(Request $request, PositionsRepositoryInterface $repository): JsonResponse|PositionsCollection
    {
        $positions = $repository->getAllPositions();

        if (count($positions) <= 0) {
            // errors
            return $this->apiResponse([
                'success' => false,
                'message' => 'Positions not found',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);

        }
        $data = new PositionsCollection($positions);

        // success
        return apiFormatResponse(
            code: Response::HTTP_OK,
            data: $data,
            status: true
        );

    }
}
