<?php

$app->get('/', function ($req, $res) {
    $this->log->info("moc '/' route");
    return $res->withRedirect('/api');
});

$app->group("/api", function() {
    /* Automatically loads route files from the Routes subdirectory */
    $routeFiles = (array)glob('app/src/Routes/*.php');
    foreach ($routeFiles as $routeFile) {
        require_once $routeFile;
    }
})->add(function ($req, $res, $next) {
    $res = $res->withHeader(
        'Content-Type',
        'application/json'
    );
    return $next($req, $res);
});
