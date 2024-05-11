<?php

namespace app\Core;

class Tests
{
    public function run(): void 
    {
        foreach (glob(BASE_PATH . '/app/Tests/ServiceTests/*.php') as $filename)
        {
            ob_start();

            include_once $filename;
        }
    }
}