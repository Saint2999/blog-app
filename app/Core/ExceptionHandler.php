<?php

namespace app\Core;

final class ExceptionHandler
{
    public function init(): void
    {
        set_exception_handler(array($this, 'defaultHandler'));
    }

    public static function defaultHandler(\Throwable $exception) 
    {
        (new Response(
            'templates/uncaughtException',
            ['error' => $exception->getMessage()]
        ))->render();
    }
}