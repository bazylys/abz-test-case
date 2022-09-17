<?php

namespace App\Contracts;

interface UsersRepositoryInterface
{
    public function getAllUsers();

    public function getUser($userId);
}
