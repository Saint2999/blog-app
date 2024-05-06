<?php

namespace app\Helpers;

final class Env
{
    private static array $config = [];

    public static function get(string $key): string
    {
        if (empty(self::$config)) {
            self::$config = require __DIR__ . '/../../config/config.php';
        }

        return self::$config[$key];
    }
}