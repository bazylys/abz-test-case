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

    public function index(array $params = [])
    {
        $perPage = $params['count'] ?? 5;

        $page = $params['page'] ?? 1;

        if (isset($params['offset'])) {
            $page = $params['offset'] / $perPage;
        }

        return User::query()
            ->with('position')
            ->orderBy('id', 'desc')
            ->paginate(perPage: $perPage, page: $page);
    }

    public function show($userId)
    {
        return User::query()->findOr($userId, function () {
            throw new UserNotFoundException();
        });
    }

    public function create($data): bool|int
    {
        $user =  User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'position_id' => $data['position_id'],
            'photo' => $data['photo'],
        ]);

        return $user->id;
    }
}
