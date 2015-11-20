<?php
namespace MocApi\Router;

class Router {

    function __construct($app) {
        $app->get('/', function () use ($app) {
            $app->log->info("moc '/' route");
        });

        $app->notFound(function () use ($app) {
            $app->halt(404, "Route not found");
        });

        /* Automatically loads route files from the Routes subdirectory */
        $routeFiles = (array)glob('MocApi/Router/Routes/*.php');
        foreach ($routeFiles as $routeFile) {

            /* Get class name */
            $routeFile = explode(".", $routeFile)[0];
            $routeFile = explode('/', $routeFile);
            $routeFile = $routeFile[count($routeFile) - 1];

            $fullClassName = __NAMESPACE__ . '\\Routes\\' . $routeFile;

            if (method_exists($fullClassName, 'route')) {
                forward_static_call(array($fullClassName, 'route'), $app);
            } else {
                $app->log->error("Tried to load route: '$fullClassName' without route method");
            }
        }


    }
}
