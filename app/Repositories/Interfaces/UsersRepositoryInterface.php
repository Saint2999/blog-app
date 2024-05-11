<?php

namespace app\Repositories\Interfaces;

use app\Models\User;

interface UsersRepositoryInterface 
{
    public function getUserByName(string $name): ?User;

    public function createUser(array $details): ?User;
}