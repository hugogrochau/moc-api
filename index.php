<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/vendor/autoload.php';
// Propel config
require __DIR__ . '/conf/config.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/app/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/app/dependencies.php';

// Register middleware
require __DIR__ . '/app/middleware.php';

// Register routes
require __DIR__ . '/app/routes.php';

// Run!
$app->run();
