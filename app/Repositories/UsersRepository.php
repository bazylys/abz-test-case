<?php

namespace App\Repositories;

use App\Contracts\UsersRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UsersRepository implements UsersRepositoryInterface
{
    public function getAllUsers(): \Illuminate\Contracts\Pagination\Paginator
    {
        return User::query()->with('position')->simplePaginate(15);
    }
}
