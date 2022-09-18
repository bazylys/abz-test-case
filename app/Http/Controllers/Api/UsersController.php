<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexUserRequest;
use App\Http\Requests\ShowUserRequest;
use App\Http\Resources\UsersCollection;
use App\Http\Resources\UsersResource;
use App\Contracts\UsersRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function index(IndexUserRequest $request, UsersRepositoryInterface $usersRepository)
    {
        $data = new UsersCollection($usersRepository->getAllUsers());

        $dataArray = $data->response($request)->getData(true);

        // sending users to end of response :)
        // TODO: fix this part
        $users = $dataArray['users'];
        unset($dataArray['users']);
        $dataArray['users'] = $users;

        return apiFormatResponse(
            code: Response::HTTP_OK,
            data: $dataArray,
            status: true
        );
    }

    public function show(ShowUserRequest $request, $user_id, UsersRepositoryInterface $usersRepository)
    {
        $data = UsersResource::make($usersRepository->getUser($user_id));

        return apiFormatResponse(
            code: Response::HTTP_OK,
            data: $data,
            status: true
        );
    }

    public function store()
    {
    }
}
