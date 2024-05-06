<?php

namespace app\Repositories;

use app\Models\User;

class UsersRepository 
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