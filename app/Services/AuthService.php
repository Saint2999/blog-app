<?php

namespace app\Services;

use app\Core\SessionManager;
use app\Repositories\UsersRepository;
use app\DTOs\UserDTO;

class AuthService
{
    private UsersRepository $repository;

    public function __construct() 
    {
        $this->repository = new UsersRepository();
    }

    public function login(UserDTO $userDTO): void
    {
        if (SessionManager::has('authenticated')) {
            return;
        }

        $user = $this->repository->getUserByName($userDTO->name);

        if (!$user) {
            throw new \Exception("User not found", 401);
        }

        if (!password_verify($userDTO->password, $user->password)) {
            throw new \Exception("Wrong password", 401);
        }

        $this->authenticateWithSession($user->id, $user->name);
    }

    public function register(UserDTO $userDTO): void
    {
        if (SessionManager::has('authenticated')) {
            return;
        }

        $user = $this->repository->getUserByName($userDTO->name);

        if ($user) {
            throw new \Exception("User already exists", 401);
        }

        $user = $this->repository->createUser([
            'name' => $userDTO->name,
            'password' => password_hash($userDTO->password, PASSWORD_DEFAULT)
        ]);
        
        if (!$user) {
            throw new \Exception("User could not be created", 500);
        }

        $this->authenticateWithSession($user->id, $user->name);
    }

    public function logout(): void
    {
        SessionManager::remove('authenticated');

        SessionManager::remove('id');

        SessionManager::remove('name');

        session_regenerate_id();
    }

    private function authenticateWithSession(string $id, string $name): void
    {
        session_regenerate_id();

        SessionManager::set('authenticated', true);

        SessionManager::set('id', $id);

        SessionManager::set('name', $name);
    }
}