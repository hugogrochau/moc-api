<?php
namespace MocApi\Routes;

use MocApi\Route;
use MocApi\Middleware\LoggedInMiddleware;

/**
 * UserRoute
 *
 * @package MocApi\Router\Routes
 */

$this->group("/user", function () {

    $this->post("/register", function ($req, $res, $id) {
        $postData = $res->getParsedBody();
        $username = $postData['username'];
        $password = $postData['password'];
        $name = $postData['password'];

        if (User::register($username, $password, $name)) {
            return $res->withStatus(200)->write('Registered');
        } else {
            return $res->withStatus(403)->write('Error while registering');
        }
    });

    $this->post("/login", function ($req, $res, $id) {
        $postData = $res->getParsedBody();
        $username = $postData['username'];
        $password = $postData['password'];

        if (User::authenticate($username, $password)) {
            $_SESSION['username'] = $username;
            return $res->withStatus(200)->write('Logged in');

        } else {
            return $res->withStatus(401)->write('Wrong username or password');
        }
    });

    $this->get("/logout", function ($req, $res, $id) {
        unset($_SESSION['username']);
        return $res->withStatus(200)->write('Logged out');
    })->add(new LoggedInMiddleware());
});
