<?php

const BASE_PATH = __DIR__ . '/../';
  
spl_autoload_register(function($class) {

    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);

    require BASE_PATH . "{$class}.php";
});

use bootstrap\app;

$app = new App();

require_once '../routes/web.php';

$app->run();