<?php

namespace app\Services\Interfaces;

use app\DTOs\UserDTO;

interface AuthServiceInterface 
{
    public function login(UserDTO $userDTO): void;

    public function register(UserDTO $userDTO): void;

    public function logout(): void;
}