<?php

namespace app\Repositories;

use app\Repositories\Interfaces\UsersRepositoryInterface;
use app\Models\User;

class UsersRepository implements UsersRepositoryInterface
{
    public function getUserByName(string $name): ?User
    {
        $users = User::where('name', $name);

        $user = reset($users);

        if (!$user) {
            return null;
        }

        return $user; 
    }

    public function createUser(array $details): ?User
    {
        return User::create($details);
    }
}