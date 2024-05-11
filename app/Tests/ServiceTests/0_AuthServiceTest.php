<?php

namespace app\Tests\ServiceTests;

use app\Core\SessionManager;
use app\Services\AuthService;
use app\Tests\Fake\Repositories\FakeUsersRepository;
use app\DTOs\UserDTO;
use app\Helpers\DTOHydrator;

final class AuthServiceTest
{
    public function __construct()
    {
        echo '<br>' . get_class($this) . ' <br>';

        $this->testLogin();

        $this->testRegister();
    }

    public function testLogin()
    {
        $service = new AuthService(new FakeUsersRepository());

        $userDTO = DTOHydrator::hydrate(
            [
                'name' => 'Anton',
                'password' => 'qwerty'
            ],
            new UserDTO()
        );
        
        try {
            $service->login($userDTO);
        } catch (\Throwable $e) {
            echo 'Test Login Failure: ';
            echo $e->getMessage() . ' <br>';

            SessionManager::clear();

            return;
        }

        if (
            !SessionManager::has('authenticated') || 
            SessionManager::get('name') != 'Anton'
        ) {
            echo 'Test Login Failure: Session <br>';

            SessionManager::clear();

            return;
        }

        echo 'Test Login: Success <br>';

        SessionManager::clear();
    }

    public function testRegister() 
    {
        $service = new AuthService(new FakeUsersRepository());

        $userDTO = DTOHydrator::hydrate(
            [
                'id' => 2,
                'name' => 'John',
                'password' => 'qwerty'
            ],
            new UserDTO()
        );
        
        try {
            $service->register($userDTO);
        } catch (\Throwable $e) {
            echo 'Test Register Failure: ';
            echo $e->getMessage() . ' <br>';

            SessionManager::clear();

            return;
        }

        if (
            !SessionManager::has('authenticated') || 
            SessionManager::get('id') != 2 ||
            SessionManager::get('name') != 'John'
        ) {
            echo 'Test Register Failure: Session <br>';

            SessionManager::clear();

            return;
        }

        echo 'Test Register Success <br>';

        SessionManager::clear();
    }
}

new AuthServiceTest();