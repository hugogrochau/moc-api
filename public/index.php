<?php

// remember to dump-autoload after adding new modules
require '../vendor/autoload.php';
use models\Hospital;

// Prepare app
$app = new \Slim\Slim(array(
    'templates.path' => '../templates',
));

// Create monolog logger and store logger in container as singleton
// (Singleton resources retrieve the same log resource definition each time)
$app->container->singleton('log', function () {
    $log = new \Monolog\Logger('moc');
    $log->pushHandler(new \Monolog\Handler\StreamHandler('../logs/app.log', \Monolog\Logger::DEBUG));
    return $log;
});

// Prepare view
$app->view(new \Slim\Views\Twig());
$app->view->parserOptions = array(
    'charset' => 'utf-8',
    'cache' => realpath('../templates/cache'),
    'auto_reload' => true,
    'strict_variables' => false,
    'autoescape' => true
);
$app->view->parserExtensions = array(new \Slim\Views\TwigExtension());

// Define routes
$app->get('/', function () use ($app) {
    // Sample log message
    $app->log->info("moc '/' route");
    // Render index view
    $app->render('index.html');
});


$app->get('/api/hospital/:id', function ($id) use ($app) {
  $app->log->info("moc '/api/hospital/$id' route");
  echo json_encode(Hospital::getHospitalById($id));

});
// Run app
$app->run();
