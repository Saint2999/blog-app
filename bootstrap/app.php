<?php

namespace bootstrap;

use app\Core\ExceptionHandler;
use app\Core\Migrations;
use app\Core\Seeders;
use app\Core\SessionManager;
use app\Core\RateLimiter;
use app\Core\DependencyInjectionContainer;
use app\Core\Router;
use app\Core\Request;
use app\Core\Tests;
use app\Helpers\Env;

class App
{
    public function run(): void 
    {
        SessionManager::init();

        if (Env::get('APP_TEST')) {
            (new Tests)->run();

            return;
        }

        (new ExceptionHandler)->init();

        (new Migrations)->run();
        
        (new Seeders)->run();

        RateLimiter::init();

        $container = new DependencyInjectionContainer(
            require_once BASE_PATH . '/config/dependencyInjection.php'
        );

        $router = Router::getInstance($container);

        $request = new Request();

        $response = $router->route($request);

        RateLimiter::addToTimeline($request);

        $response->render();
    }
}