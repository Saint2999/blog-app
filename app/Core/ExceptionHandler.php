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

    public static function getPDOError($errorCode = 0) 
    {
        $errors = [
            '23000' => "Already exists",
        ];
        
        return array_key_exists($errorCode, $errors) ? $errors[$errorCode] : 'Unknown Error';
    }
}