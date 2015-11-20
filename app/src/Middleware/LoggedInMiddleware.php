<?php
namespace MocApi\Middleware;

/**
 * Checks if user is logged in
 * @package MocApi\Middleware
 */
class LoggedInMiddleware {
    /**
     * Checks if user is logged in and passes the response to the next middleware
     *
     */
    public function __invoke($req, $res, $next) {
        if (!isset($_SESSION['username'])) {
            return $res->withStatus(401)->write('Not logged in');
        }
        return $response = $next($req, $res);
    }
}