<?php

namespace bootstrap;

use app\Core\ExceptionHandler;
use app\Core\Migrations;
use app\Core\Seeders;
use app\Core\SessionManager;
use app\Core\RateLimiter;
use app\Core\Router;
use app\Core\Request;

class App
{
    public function run(): void 
    {
        SessionManager::init();

        (new ExceptionHandler)->init();

        (new Migrations)->run();
        
        (new Seeders)->run();

        RateLimiter::init();

        $router = Router::getInstance();

        $request = new Request();

        $response = $router->route($request);

        RateLimiter::addToTimeline($request);

        $response->render();
    }
}