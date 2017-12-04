<?php

namespace App\Middleware;

use \Slim\Http\Response;
use \Slim\Http\Request;

class ApiMiddleware extends AbstractMiddleware {

    /**
     * ApiMiddleware invoke method
     *
     * @param Request  $request
     * @param Response $response
     * @param callable $next
     *
     * @return mixed
     */
    public function __invoke($request, $response, $next)
    {
        $response = $next($request, $response);
        return $response;
    }
}
