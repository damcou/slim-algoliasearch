<?php

namespace App\Middleware;

use \Slim\Views\Twig as TwigView;

class AbstractMiddleware {


    protected $container;

    /**
     * AbstractMiddleware Constructor
     *
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Get View
     *
     * @return TwigView
     */
    protected function getView()
    {
        return $this->container->view;
    }
}
