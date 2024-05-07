<?php

namespace app\Controllers;

use app\Core\Request;
use app\Core\Response;
use app\Core\SessionManager;
use app\Services\AuthService;
use app\Enums\AuthenticationType;
use app\Validation\Validator;
use app\Validation\Rules\NotNull;
use app\Validation\Rules\StringLength;
use app\DTOs\UserDTO;
use app\Helpers\DTOHydrator;
use app\Helpers\Redirector;

class AuthController
{
    private AuthService $service;

    public function __construct()
    {
        $this->service = new AuthService();
    }

    public function showLogin(Request $request): Response
    {
        return $this->showAuth(AuthenticationType::Login);
    }

    public function showRegister(Request $request): Response
    {
        return $this->showAuth(AuthenticationType::Register);
    }

    public function login(Request $request): ?Response
    {
        return $this->authenticate($request, AuthenticationType::Login);
    }

    public function register(Request $request): ?Response
    {
        return $this->authenticate($request, AuthenticationType::Register);
    }

    public function logout(Request $request)
    {
        $this->service->logout();

        Redirector::redirect('/articles');
    }

    private function showAuth(AuthenticationType $type): Response
    {
        SessionManager::set('csrf-token', bin2hex(random_bytes(32)));

        return new Response(
            'auth/auth', 
            [
                'type' => $type->value,
                'csrfToken' => SessionManager::get('csrf-token'),
            ]
        );
    }

    private function authenticate(Request $request, AuthenticationType $type): ?Response
    {
        $token = $request->getParam('csrf-token');

        if (!$token || !hash_equals(SessionManager::get('csrf-token'), $token)) {
            SessionManager::set('csrf-token', bin2hex(random_bytes(32)));

            return new Response(
                'auth/auth', 
                [
                    'type' => $type->value,
                    'csrfToken' => SessionManager::get('csrf-token'),
                    'errors' => ['Invalid form submission']
                ]
            );
        }

        $validator = new Validator([
            'name' => [(new StringLength())->min(3)->max(255), new NotNull()],
            'password' => [(new StringLength())->min(8)->max(255), new NotNull()]
        ]);

        if (!$validator->validate($request->getParams())) {
            return new Response(
                'auth/auth', 
                [
                    'type' => $type->value,
                    'csrfToken' => SessionManager::get('csrf-token'),
                    'errors' => $validator->getErrors()
                ]
            );
        }

        $userDTO = DTOHydrator::hydrate(
            $request->getParams(),
            new UserDTO()
        );

        try {
            switch ($type) {
                case AuthenticationType::Login:
                    $this->service->login($userDTO);
                    
                    break;
                
                case AuthenticationType::Register:
                    $this->service->register($userDTO);
                    
                    break;
            }
        } catch (\Exception $e) {
            return new Response(
                'auth/auth', 
                [
                    'type' => $type->value,
                    'csrfToken' => SessionManager::get('csrf-token'),
                    'errors' => [$e->getMessage()]
                ]
            );
        }

        Redirector::redirect('/articles');
    }
}