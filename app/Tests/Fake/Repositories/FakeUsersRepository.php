<?php

namespace app\Tests\Fake\Repositories;

use app\Repositories\Interfaces\UsersRepositoryInterface;
use app\Models\User;

final class FakeUsersRepository implements UsersRepositoryInterface
{
    private array $users = [];

    public function __construct()
    {
        $this->users = [
            'Anton' => User::init(
                1, 
                'Anton',
                password_hash('qwerty', PASSWORD_DEFAULT),
                time()
            )
        ];
    }

    public function getUserByName(string $name): ?User
    {
        return $this->users[$name] ?? null;
    }

    public function createUser(array $details): ?User
    {
        $this->users[$details['name']] = User::init(
            count($this->users) + 1, 
            $details['name'],
            password_hash($details['password'], PASSWORD_DEFAULT),
            time()
        );

        return $this->users[$details['name']] ?? null;
    }
}