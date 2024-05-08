<?php

namespace app\Core;

final class SessionManager
{
    public static function init(string $cacheExpire = null, string $cacheLimiter = null): void
    {
        if (session_status() !== PHP_SESSION_NONE) {
            return;
        }

        if ($cacheLimiter !== null) {
            session_cache_limiter($cacheLimiter);
        }

        if ($cacheExpire !== null) {
            session_cache_expire($cacheExpire);
        }

        session_start();
    }

    public static function get(string $key): string|null|array
    {
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }

        return null;
    }

    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function remove(string $key): void
    {
        if (array_key_exists($key, $_SESSION)) {
            unset($_SESSION[$key]);
        }
    }

    public static function clear(): void
    {
        session_unset();
    }

    public static function has(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }
}