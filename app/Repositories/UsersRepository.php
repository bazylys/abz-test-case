<?php

namespace App\Repositories;

use App\Contracts\UsersRepositoryInterface;
use App\Exceptions\UserNotFoundException;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class UsersRepository implements UsersRepositoryInterface
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getAllUsers()
    {
        $perPage = $this->request->count ?? 5;

        $page = $this->request->page ?? 1;

        if ($this->request->filled('offset')) {
            $page = $this->request->offset / $perPage;
        }

        return User::query()
            ->with('position')
            ->orderBy('id', 'desc')
            ->paginate(perPage: $perPage, page: $page);
    }

    public function getUser($userId)
    {
        return User::query()->findOr($userId, function () {
            throw new UserNotFoundException();
        });
    }
}
