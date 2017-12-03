<?php

namespace App\Middleware;

use \Slim\Http\Response;
use \Slim\Http\Request;

class LoggedMiddleware extends AbstractMiddleware {

    /**
     * LoggedMiddleware
     *
     * @param Request  $request
     * @param Response $response
     * @param callable $next
     *
     * @return mixed
     */
    public function __invoke($request, $response, $next)
    {
        if (! $this->container->session->check()) {
            return $response->withRedirect($this->container->router->pathFor('admin_login'));
        }

        $response = $next($request, $response);
        return $response;
    }
}