<?php
namespace MocApi\Middleware;

use Slim\Middleware;
/**
 * Checks if user is logged in
 * @package MocApi\Middleware
 */
class NotLoggedInMiddleware {
    /**
     * Checks if user is logged in and passes the response to the next middleware
     *
     */
    public function __invoke($req, $res, $next) {
        if (isset($_SESSION['username'])) {
            return $res->withStatus(401)->write('Already logged in');
        }
        return $next($req, $res);
    }
}