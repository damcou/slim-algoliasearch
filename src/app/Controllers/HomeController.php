<?php

namespace App\Controllers;

use \Slim\Http\Response;
use \Slim\Http\Request;
use \Slim\Container;
use \Slim\Views\Twig as TwigView;

class HomeController
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * HomeController constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Index view
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index($request, $response, $args)
    {
        return $this->getView()->render($response, 'index.twig', $args);
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
        return $this->getContainer()->view;
    }
}
