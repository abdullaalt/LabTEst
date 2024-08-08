<?php

spl_autoload_register(function ($className) {
    $file = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
    
    if (file_exists($file)) {
        include $file;
    }
});

require_once __DIR__.'/config/database.php';

require_once __DIR__.'/Core/Request.php';
require_once __DIR__.'/Core/Core.php';
require_once __DIR__.'/Core/DB.php';

$request = new Request();

$core = new Core($request);

$core->run();