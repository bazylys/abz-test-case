<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexUserRequest;
use App\Http\Requests\ShowUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UsersCollection;
use App\Http\Resources\UsersResource;
use App\Contracts\UsersRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public $usersRepository;

    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function index(IndexUserRequest $request)
    {
        $data = new UsersCollection($this->usersRepository->index());

        $dataArray = $data->response($request)->getData(true);

        // sending users to end of response ;)
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

    public function show(ShowUserRequest $request, $user_id)
    {
        $data = UsersResource::make($this->usersRepository->show($user_id));

        return apiFormatResponse(
            code: Response::HTTP_OK,
            data: $data,
            status: true
        );
    }

    public function store(StoreUserRequest $request)
    {
        $this->checkStoreUserData($request->all());

        $userId = $this->usersRepository->create($request->only([
            'name',
            'email',
            'phone',
            'position_id',
            'photo',
        ]));

        return apiFormatResponse(
            data: [
                'user_id' => $userId,
                'message' => 'New user successfully registered',
            ],
            status: true,
        );

    }

    protected function checkStoreUserData($data)
    {

    }
}
