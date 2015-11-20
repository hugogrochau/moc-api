<?php

// remember to dump-autoload after adding new modules
require './vendor/autoload.php';
require './conf/config.php';

use MocApi\Models\HospitalQuery;
use MocApi\Models\SurgeryformQuery;

use MocApi\Models\User;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Prepare MocApi
$app = new \Slim\Slim(array(
    'templates.path' => '../templates',
));
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
    $hospital = HospitalQuery::create()->findPk($id);
    if ($hospital) {
        echo $hospital->toJSON();
    } else {
        $app->halt(404, 'Hospital not found');
    }
});

/*
   SELECT s.name, s.specialty, s.crm FROM hospital AS h
   INNER JOIN hospital_surgeryform AS hsf
   ON h.id = hsf.idHospital
   INNER JOIN surgeryform AS sf
   ON hsf.idsurgeryform = sf.id
   INNER JOIN surgeon_surgeryform AS ssf
   ON sf.id = ssf.idsurgeryform
   INNER JOIN surgeon AS s
   ON ssf.idsurgeon = s.email
   WHERE h.id = $1'; */
//You must be logged in to use this feature
//$notLoggedIn($MocApi);
$app->get('/api/hospital/:id/surgery/', function($id) use ($app) {
    $app->log->info("moc '/api/hospital/$id/surgery/' route");
    $hospital = HospitalQuery::create()->findPk($id);
    $surgeryForms = SurgeryformQuery::create()
                    ->filterByHospital($hospital)
                    ->joinWithSurgeonSurgeryform()
                    ->useSurgeonSurgeryformQuery()
                    ->joinWithSurgeon()
                    ->useSurgeonQuery()
                    ->select(array("Surgeon.Name", "Surgeon.Crm", "Surgeon.Specialty"))
                    ->find();
    echo $surgeryForms->toJSON();
});

// Run MocApi
$app->run();
