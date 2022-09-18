<?php

namespace App\Contracts;

interface UsersRepositoryInterface
{
    public function index();

    public function show($userId);

    public function create($data);
}
