<?php

namespace app\Core;

class Router
{
    private const HTTP_GET = 'GET';
    private const HTTP_POST = 'POST';

    private static array $routes = [];

    private static $router;

    private DependencyInjectionContainer $container;

    private function __construct(DependencyInjectionContainer $container) 
    {
        $this->container = $container;
    }

    public static function getInstance(DependencyInjectionContainer $container): self {

        if(!isset(self::$router)) {

            self::$router = new self($container);
        }

        return self::$router;
    }

    public static function get(string $uri, string $action): void
    {
        self::registerRoute($uri, $action, self::HTTP_GET);
    }

    public static function post(string $uri, string $action): void
    {
        self::registerRoute($uri, $action, self::HTTP_POST);
    }

    private static function registerRoute(string $uri, string $action, string $method)
    {
        list($controller, $function) = explode('@', $action, 2);

        self::$routes[$method][$uri] = [
            'controller' => $controller,
            'function' => $function
        ];
    }

    public function route(Request $request): Response
    {
        $path = $request->getPath();
        $method = $request->getMethod();

        $callback = self::$routes[$method][$path] ?? null;

        if (!$callback) {
            throw new \Exception('Not found', 404);
        }

        $controller = $callback['controller'];
        $function = $callback['function'];

        if(!class_exists($controller)) {
            throw new \Exception('Class not found', 500);
        }

        $controllerInstance = $this->container->get($controller);

        if(!method_exists($controllerInstance, $function)) {
            throw new \Exception('Class method not found', 500);
        }

        return $controllerInstance->$function($request);
    }
}