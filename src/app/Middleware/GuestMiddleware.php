<?php

namespace App\Middleware;

use \Slim\Http\Response;
use \Slim\Http\Request;

class GuestMiddleware extends AbstractMiddleware {

    /**
     * GuestMiddleware invoke method
     *
     * @param Request  $request
     * @param Response $response
     * @param callable $next
     *
     * @return mixed
     */
    public function __invoke($request, $response, $next)
    {
        if ($this->container->session->check()) {
            return $response->withRedirect($this->container->router->pathFor('admin'));
        }

        $response = $next($request, $response);
        return $response;
    }
}
