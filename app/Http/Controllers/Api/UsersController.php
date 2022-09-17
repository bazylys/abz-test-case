<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexUserRequest;
use App\Http\Requests\ShowUserRequest;
use App\Http\Resources\UsersCollection;
use App\Http\Resources\UsersResource;
use App\Contracts\UsersRepositoryInterface;

class UsersController extends Controller
{
    public function index(IndexUserRequest $request, UsersRepositoryInterface $usersRepository)
    {
        return UsersCollection::make($usersRepository->getAllUsers());
    }

    public function show(ShowUserRequest $request, $user_id, UsersRepositoryInterface $usersRepository)
    {
        return UsersResource::make($usersRepository->getUser($user_id));
    }

    public function store()
    {
    }
}
