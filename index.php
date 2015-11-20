<?php

// remember to dump-autoload after adding new modules
require './vendor/autoload.php';
require './conf/config.php';

use MocApi\Router\Router;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Prepare MocApi
$app = new \Slim\Slim();

$app->response->headers->set('Content-Type', 'application/json');

// Create monolog logger and store logger in container as singleton
// (Singleton resources retrieve the same log resource definition each time)
$app->container->singleton('log', function () {
    $log = new \Monolog\Logger('moc');
    $log->pushHandler(new \Monolog\Handler\StreamHandler('./logs/MocApi.log', \Monolog\Logger::DEBUG));
    return $log;
});

// Session cookie middleware
$app->add(new \Slim\Middleware\SessionCookie(array('secret' => 'myappsecret')));

new Router($app);

// Run MocApi
$app->run();
