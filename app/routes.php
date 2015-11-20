<?php

$app->get('/', function ($req, $res) {
    $this->log->info("moc '/' route");
});

/* Automatically loads route files from the Routes subdirectory */
$routeFiles = (array)glob('app/src/Routes/*.php');
foreach ($routeFiles as $routeFile) {
    require_once $routeFile;
}