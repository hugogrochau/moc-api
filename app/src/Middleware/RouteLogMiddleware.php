<?php
namespace MocApi\Middleware;

/**
 * Logs route request
 * @package MocApi\Middleware
 */
class RouteLogMiddleware {

    public function __construct($log) {
        $this->log = $log;
    }

    public function run($req, $res, $next) {
        $this->log->info('route: ' . $req->getUri()->getPath());
        return $next($req, $res);
    }

    public function __invoke($req, $res, $next) {
        $this->run($req, $res, $next);
    }
}