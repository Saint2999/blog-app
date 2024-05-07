<?php

namespace bootstrap;

use app\Core\UncaughtExceptionHandler;
use app\Core\Migrations;
use app\Core\Seeders;
use app\Core\SessionManager;
use app\Core\Router;
use app\Core\Request;

class App
{
    public function run(): void 
    {
        (new UncaughtExceptionHandler)->init();

        (new Migrations)->run();
        
        (new Seeders)->run();

        SessionManager::init();

        $router = Router::getInstance();

        $request = new Request();

        $response = $router->route($request);

        $response->render();
    }
}