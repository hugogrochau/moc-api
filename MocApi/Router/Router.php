<?php
namespace MocApi\Router;

use MocApi\Router\HospitalRoute;
use MocApi\Router\UserRoute;

class Router {

    function __construct($app) {
        $app->get('/', function () use ($app) {
            $app->log->info("moc '/' route");
        });

        $app->notFound(function () use ($app) {
            $app->halt(404, "Route not found");
        });

        HospitalRoute::route($app, "/api/hospital");
        UserRoute::route($app, "/api/user");
    }


}
