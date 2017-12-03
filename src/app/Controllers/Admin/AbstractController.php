<?php

namespace App\Controllers\Admin;

use \Psr\Container\ContainerInterface;
use \Slim\Container;
use \Slim\Views\Twig as TwigView;
use \Slim\Flash\Messages;

abstract class AbstractController {

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * HomeController constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(
        ContainerInterface $container
    ) {
        $this->container = $container;
    }

    /**
     * @param string $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        if ($this->container->{$property}) {
            return $this->container->{$property};
        }

        return null;
    }

    /**
     * @return Container
     */
    protected function getContainer()
    {
        return $this->container;
    }

    /**
     * @return TwigView
     */
    protected function getView()
    {
        return $this->view;
    }

    /**
     * @return Messages
     */
    protected function getFlash()
    {
        return $this->flash;
    }
}
