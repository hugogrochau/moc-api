<?php
namespace MocApi\Router;

class UserRoute {

    public static function route($app, $path) {

        $app->group($path, function () use ($app) {

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

            $app->post("/register", $alreadyLoggedIn($app), function () use ($app) {
                $username = $app->request()->post('username');
                $password = $app->request()->post('password');
                $name = $app->request()->post('name');

                if (User::register($username, $password, $name)) {
                    $app->halt(200, 'Registered');
                } else {
                    $app->halt(403, 'Error while registering');
                }
            });

            $app->post("/login", $alreadyLoggedIn($app), function () use ($app) {
                $username = $app->request()->post('username');
                $password = $app->request()->post('password');

                if (User::authenticate($username, $password)) {
                    $_SESSION['username'] = $username;
                    $app->halt(200, 'Logged in');
                } else {
                    $app->halt(401, 'Wrong username or password');
                }
            });

            $app->get("/logout", $notLoggedIn($app), function () use ($app) {
                unset($_SESSION['username']);
                $app->halt(200, 'Logged out');
            });
        });

    }
}
?>