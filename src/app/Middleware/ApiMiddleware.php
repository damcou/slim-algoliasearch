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
        // Perform quick Authorization check to reach API endpoints
        $settings    = \App\Helper\Config::getSettings();
        $authHeaders = $request->getHeader("HTTP_AUTHORIZATION");
        $authorized  = false;

        foreach ($authHeaders as $authHeader) {
            if ($authHeader == $settings['admin_account']['auth_token']) {
                $authorized = true;
                break;
            }
        }

        if (! $authorized) {
            return $response->withStatus(403, 'Invalid authorization token.');
        }

        $response = $next($request, $response);
        return $response;
    }
}
