<?php

namespace app\Core;

class Router
{
    private const HTTP_GET = 'GET';
    private const HTTP_POST = 'POST';
    private const HTTP_PUT = 'PUT';
    private const HTTP_PATCH = 'PATCH';
    private const HTTP_DELETE = 'DELETE';

    private static array $routes = [];

    private static $router;

    private function __construct() {}

    public static function getInstance(): self {

        if(!isset(self::$router)) {

            self::$router = new self();
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

    public static function put(string $uri, string $action): void
    {
        self::registerRoute($uri, $action, self::HTTP_PUT);
    }

    public static function patch(string $uri, string $action): void
    {
        self::registerRoute($uri, $action, self::HTTP_PATCH);
    }

    public static function delete(string $uri, string $action): void
    {
        self::registerRoute($uri, $action, self::HTTP_DELETE);
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
            throw new \Exception('Server error: Class not found', 500);
        }

        $controllerInstance = new $controller();

        if(!method_exists($controllerInstance, $function)) {
            throw new \Exception('Server error: Class method not found', 500);
        }

        return $controllerInstance->$function($request);
    }
}