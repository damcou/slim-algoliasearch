<?php

namespace App\Middleware;

use \Slim\Http\Response;
use \Slim\Http\Request;
use \Slim\Csrf\Guard as CsrfGuard;

class CsrfGuardMiddleware extends AbstractMiddleware {

    /**
     * CsrfGuardMiddleware invoke method
     *
     * @param Request  $request
     * @param Response $response
     * @param callable $next
     *
     * @return mixed
     */
    public function __invoke($request, $response, $next)
    {
        $this->getView()->getEnvironment()->addGlobal(
            'csrf_fields',
            '<input type="hidden" name="'.$this->getCsrfGuard()->getTokenNameKey().'" value="'.$this->getCsrfGuard()->getTokenName().'">
             <input type="hidden" name="'.$this->getCsrfGuard()->getTokenValueKey().'" value="'.$this->getCsrfGuard()->getTokenValue().'">
            '
        );

        $response = $next($request, $response);
        return $response;
    }

    /**
     * Get CSRF guard
     *
     * @return CsrfGuard
     */
    protected function getCsrfGuard()
    {
        return $this->container->csrf;
    }
}
