<?php

// remember to dump-autoload after adding new modules
require '../vendor/autoload.php';
use MocApi\Models\Hospital;
use MocApi\Models\User;

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

// Session cookie middleware
$app->add(new \Slim\Middleware\SessionCookie(array('secret' => 'myappsecret')));

// Check if user isn't logged in
$notLoggedIn = function ($app) {
    return function () use ($app) {
        if (!isset($_SESSION['username'])) {
            $app->halt(401, 'Not logged in');
        }
    };
};

// Check if user is already logged in
$alreadyLoggedIn = function ($app) {
    return function () use ($app) {
        if (isset($_SESSION['username'])) {
            $app->halt(403, 'Already logged in');
        }
    };
};

// Define routes
$app->get('/', function () use ($app) {
    // Sample log message
    $app->log->info("moc '/' route");
});

$app->post("/api/user/register", $alreadyLoggedIn($app), function () use ($app) {
    $username = $app->request()->post('username');
    $password = $app->request()->post('password');
    $name = $app->request()->post('name');

    if (User::register($username, $password, $name)) {
        $app->halt(200, 'Registered');
    } else {
        $app->halt(403, 'Error while registering');
    }
});

$app->post("/api/user/login", $alreadyLoggedIn($app), function () use ($app) {
    $username = $app->request()->post('username');
    $password = $app->request()->post('password');

    if (User::authenticate($username, $password)) {
        $_SESSION['username'] = $username;
        $app->halt(200, 'Logged in');
    } else {
        $app->halt(401, 'Wrong username or password');
    }
});

$app->get("/api/user/logout", $notLoggedIn($app), function () use ($app) {
    unset($_SESSION['username']);
    $app->halt(200, 'Logged out');
});

$app->get('/api/hospital/:id', function ($id) use ($app) {
    $app->log->info("moc '/api/hospital/$id' route");
    echo json_encode(Hospital::getHospitalById($id));
});

$app->get('/api/hospital/:id/surgery/', $notLoggedIn($app), function($id) use ($app) {

    echo "foo";
});

// Run app
$app->run();
