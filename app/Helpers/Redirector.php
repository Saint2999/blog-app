<?php

namespace app\Helpers;

final class Redirector
{
    public static function redirect(string $path)
    {
       header('Location: ' . Env::get('APP_URL') . $path);

       die();
    }
}