<?php

namespace App\Contracts;

interface UsersRepositoryInterface
{
    public function index(array $params = []);

    public function show($userId);

    public function create($data);
}
